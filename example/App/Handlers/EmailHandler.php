<?php

namespace App\Handlers;

use App\Formatter;
use Nette\Mail\Message;
use Nette\Mail\SmtpMailer;
use SpencerMortensen\Exceptions\Handler;
use Throwable;

class EmailHandler implements Handler
{
	private $formatter;
	private $mailer;
	private $email;

	public function __construct (Formatter $formatter, array $mailerSettings, array $email)
	{
		$this->formatter = $formatter;
		$this->mailer = new SmtpMailer($mailerSettings);
		$this->email = $email;
	}

	public function handle (Throwable $throwable)
	{
		$subject = $this->formatter->getEmailSubject($throwable);
		$body = $this->formatter->getEmailBody($throwable);

		$this->send($subject, $body, $this->email['from'], $this->email['to']);
	}

	private function send (string $subject, string $body, string $from, string $to)
	{
		$message = new Message();
		$message->setSubject($subject);
		$message->setBody($body);
		$message->setFrom($from);
		$message->addTo($to);

		$this->mailer->send($message);
	}
}
