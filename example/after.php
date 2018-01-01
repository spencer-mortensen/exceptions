<?php

use SpencerMortensen\Exceptions\Exceptions;

require __DIR__ . '/autoload.php';

Exceptions::enable();

try {
	define(Pi, 3.14159265359);
} catch (ErrorException $exception) {
	Exceptions::disable();
	echo "exception!\n";
}
