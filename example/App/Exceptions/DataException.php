<?php

namespace App\Exceptions;

use Exception;

class DataException extends Exception
{
	private $data;

	public function __construct (string $message = null, array $data = null, int $code = null)
	{
		parent::__construct($message, $code);

		$this->data = $data;
	}

	public function getData (): ?array
	{
		return $this->data;
	}
}
