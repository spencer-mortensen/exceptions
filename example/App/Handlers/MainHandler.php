<?php

namespace App\Handlers;

use App\Formatter;
use SpencerMortensen\Exceptions\Handler;
use Throwable;

class MainHandler implements Handler
{
	private $settings;
	private $useTerminal;

	public function __construct (array $settings, bool $useTerminal)
	{
		$this->settings = $settings;
		$this->useTerminal = $useTerminal;
	}

	public function handle (Throwable $throwable)
	{
		$formatter = new Formatter(
			$this->settings['project'],
			$this->settings['paths']['code'] . '/',
			$this->settings['timeZone'],
			$this->settings['paths']['www'] . '/theme/500/basic/index.htm',
			$this->settings['paths']['www'] . '/theme/500/full/index.htm'
		);

		$logPath = $this->settings['errors']['log'] ?? null;

		if ($logPath !== null) {
			$handler = new LogHandler($formatter, $logPath);
			$handler->handle($throwable);
		}

		$email = $this->settings['errors']['email'] ?? null;

		if ($email !== null) {
			$handler = new EmailHandler($formatter, $this->settings['mail'], $email);
			$handler->handle($throwable);
		}

		if ($this->useTerminal) {
			$handler = new TerminalHandler($formatter);
			$handler->handle($throwable);
		} else {
			$method = $this->settings['errors']['expose'] ? 'getHtmlFull' : 'getHtmlBasic';
			$handler = new WebHandler([$formatter, $method]);
			$handler->handle($throwable);
		}
	}
}
