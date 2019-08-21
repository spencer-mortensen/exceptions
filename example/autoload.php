<?php

namespace SpencerMortensen\Autoloader;

$autoloader = function (string $class) {
	$namespace = 'SpencerMortensen\\Exceptions';
	$directory = dirname(__DIR__) . '/src';

	$relativeClass = substr($class, strlen($namespace) + 1);
	$relativeFile = strtr($relativeClass, '\\', DIRECTORY_SEPARATOR) . '.php';
	$absoluteFile = $directory . DIRECTORY_SEPARATOR . $relativeFile;

	include $absoluteFile;
};

spl_autoload_register($autoloader);
