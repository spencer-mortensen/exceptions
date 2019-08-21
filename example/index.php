<?php

namespace Example;

use Error;
use ErrorException;
use Exception;
use Throwable;
use SpencerMortensen\Exceptions\ErrorHandler;
use SpencerMortensen\Exceptions\ErrorHandling;

require __DIR__ . '/autoload.php';

class C implements ErrorHandler
{
	public function __construct()
	{
		new ErrorHandling($this, E_ALL);
	}

	public function handleThrowable(Throwable $throwable)
	{
		$message = $throwable->getMessage();
		echo "HANDLED: {$message}\n";
	}

	public function run()
	{
		// define(Pi, 3.14159);
		// throw new Exception('Armageddon', 666);
		// eval('$x = ');
		require '';
	}
}

$c = new C();
$c->run();
