<?php

namespace App\Handlers;

use SpencerMortensen\Exceptions\Handler;
use App\Formatter;
use Throwable;

class LogHandler implements Handler
{
	private $formatter;
	private $logPath;

	public function __construct (Formatter $formatter, string $logPath)
	{
		$this->formatter = $formatter;
		$this->logPath = $logPath;
	}

	public function handle (Throwable $throwable)
	{
		$line = $this->formatter->getLogLine($throwable);

		$this->write($line);
	}

	private function write (string $line)
	{
		file_put_contents($this->logPath, "{$line}\n", FILE_APPEND | LOCK_EX);
	}
}
