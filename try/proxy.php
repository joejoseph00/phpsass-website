<?php

$contents = $_REQUEST['input'];
$syntax = strtolower($_REQUEST['syntax']);

if (!in_array($syntax, array('scss', 'sass'))) {
	$syntax = 'scss';
}

$filename = 'scss/' . md5($contents) . '.' . $syntax;

file_put_contents($filename, $contents);

exec($syntax . ' ' . $filename, $output);

print implode("\n", $output);

// unlink($filename);

?>
