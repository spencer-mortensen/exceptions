<?php

namespace Example;

use Error;
use ErrorException;
use Exception;
use SpencerMortensen\Exceptions\Exceptions;

require __DIR__ . '/autoload.php';

$handler = function ($exception) {
	echo "Handled: ", $exception->getMessage(), "\n";
};

Exceptions::setHandler($handler);
error_reporting(0);

try {
	Exceptions::on();

	define(Pi, 3.14159);
} catch (Exception $exception) {
	$message = $exception->getMessage();
	echo "Caught: $message\n";
} catch (Error $error) {
	$message = $error->getMessage();
	echo "Caught: $message\n";
} finally {
	Exceptions::off();
}

// throw new Exception('Armageddon', 666);
// eval('$x =');
require '';

echo "exited normally\n";
