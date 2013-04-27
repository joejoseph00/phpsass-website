<?php

require_once('phpsass/SassParser.php');

$contents = $_REQUEST['input'];

try {
	$options = array(
		'style' => 'expanded',
		'cache' => FALSE,
		'syntax' => 'scss',
		'debug' => FALSE,
		'debug_info' => FALSE,
		'load_paths' => array(),
		'filename' => '',
		'load_path_functions' => array(),
		'functions' => array(),
		'callbacks' => array(
		  'warn' => NULL,
		  'debug' => NULL,
		),
	);

	// Execute the compiler.
	$parser = new SassParser($options);
	print trim($parser->toCss($contents, false));
} catch (Exception $e) {
	print "Error: " . $e->getMessage();
}
