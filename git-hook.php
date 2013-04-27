<?php

file_put_contents("git-hook.txt", time());

# right format...
if (!isset($_REQUEST['payload'])) {
  file_put_contents("git-hook.txt", "NO PAYLOAD");
  exit;
}

try {
  $payload = json_decode($_REQUEST['payload']);
} catch (Exception $e) {
  file_put_contents("git-hook.txt", "BAD PAYLOAD JSON");
  exit;
}

if (substr($payload->repository->name, 0, 7) != 'phpsass') {
  file_put_contents("git-hook.txt", "BAD REPO NAME");
  exit;
}

if (!isset($payload->repository->pushed_at)) {
  file_put_contents("git-hook.txt", "BAD TIME\n" . $info);
  exit;
}

$updated = $payload->repository->pushed_at;

$diff = abs(time() - $updated);

if ($diff > 600) {
  file_put_contents("git-hook.txt", "BAD DIFF\n" . print_r($json, true));
  exit;
}

# should be good to pull now.
if ($payload->repository->name == 'phpsass-website') {
  `git pull >> git-hook.txt`;
}
else {
  `git submodule update >> git-hook.txt`;
}
