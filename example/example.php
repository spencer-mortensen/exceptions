<?php

namespace Example;

use ErrorException;
use Exception;
use SpencerMortensen\Exceptions\Exceptions;
use Throwable;

require __DIR__ . '/autoload.php';

$onFatalError = function (ErrorException $exception) {
	$message = $exception->getMessage();
	echo "handled fatal error: {$message}\n";
};

Exceptions::on($onFatalError);

try {
	// throw new Exception('Armageddon', 666);
	// eval('$x =');
	// define(Pi, 3.14159);
	// require 'missing_file';
} catch (Exception $exception) {
	$message = $exception->getMessage();
	echo "caught exception: $message\n";
} catch (Throwable $throwable) {
	$message = $throwable->getMessage();
	echo "caught throwable: $message\n";
}

Exceptions::off();

echo "exited normally\n";
