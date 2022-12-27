<?php

namespace App\Handlers;

use App\Formatter;
use SpencerMortensen\Exceptions\Handler;
use Throwable;

class TerminalHandler implements Handler
{
	private $formatter;

	public function __construct (Formatter $formatter)
	{
		$this->formatter = $formatter;
	}

	public function handle (Throwable $throwable)
	{
		$message = $this->formatter->getTerminalMessage($throwable);

		file_put_contents('php://stderr', "{$message}\n");
	}
}
