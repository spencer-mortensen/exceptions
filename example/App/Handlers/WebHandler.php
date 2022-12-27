<?php

namespace App\Handlers;

use App\Formatter;
use App\Html;
use SpencerMortensen\Exceptions\Handler;
use Throwable;

class WebHandler implements Handler
{
	private $handler;

	public function __construct (callable $handler)
	{
		$this->handler = $handler;
	}

	public function handle (Throwable $throwable)
	{
		$content = call_user_func($this->handler, $throwable);
		$length = strlen($content);

		header("HTTP/1.1 500 Internal Server Error");
		header("Content-Length: {$length}");

		echo $content;
	}
}
