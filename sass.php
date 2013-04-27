<?php

header('Content-type: text/css');

require_once './try/phpsass/SassParser.php';

function warn($text, $context) {
	print "/** WARN: $text, on line {$context->node->token->line} of {$context->node->token->filename} **/\n";
}
function debug($text, $context) {
	print "/** DEBUG: $text, on line {$context->node->token->line} of {$context->node->token->filename} **/\n";
}

$file = '.' . $_SERVER['PATH_INFO'];
$syntax = substr($file, -4, 4);

$options = array(
	'style' => 'expanded',
	'cache' => FALSE,
	'syntax' => $syntax,
	'debug' => FALSE,
	'callbacks' => array(
		'warn' => 'warn',
		'debug' => 'debug'
	),
);

// Execute the compiler.
$parser = new SassParser($options);
try {
	print "\n\n" . $parser->toCss($file);
} catch (Exception $e) {
	print $e->getMessage();	
}