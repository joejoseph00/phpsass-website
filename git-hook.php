<?php

file_put_contents("git-hook.txt", time());

# right format...
if (!isset($_REQUEST['payload'])) {
  file_put_contents("git-hook.txt", "NO PAYLOAD");
  exit 1;
}

try {
  $payload = json_decode($_REQUEST['payload']);
} catch ($e) {
  file_put_contents("git-hook.txt", "BAD PAYLOAD JSON");
  exit 2;
}

if (substr($payload->repository->name, 0, 7) != 'phpsass') {
  file_put_contents("git-hook.txt", "BAD REPO NAME");
  exit 2;
}

# get the info from github
$info = file_get_contents("https://api.github.com/repos/richthegeek/phpsass-website");

try {
  $json = json_decode($info);
} catch ($e) {
  file_put_contents("git-hook.txt", "BAD INFO");
  exit 3;
}

if (!isset($json->updated_at)) {
  file_put_contents("git-hook.txt", "BAD TIME");
  exit 4;
}

$updated = strtotime($json->updated_at);

$diff = abs(time() - $updated);

if ($diff > 600) {
  file_put_contents("git-hook.txt", "BAD DIFF");
  exit 5;
}

# should be good to pull now.
if ($payload->repository->name == 'phpsass-website') {
  `git pull >> git-hook.txt`
}
else {
  `git submodule update >> git-hook.txt`
}
