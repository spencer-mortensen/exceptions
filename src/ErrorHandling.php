<?php

/**
 * Copyright (C) 2017 Spencer Mortensen
 *
 * This file is part of Exceptions.
 *
 * Exceptions is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Exceptions is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Exceptions. If not, see <http://www.gnu.org/licenses/>.
 *
 * @author Spencer Mortensen <spencer@lens.guide>
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL-3.0
 * @copyright 2017 Spencer Mortensen
 */

namespace SpencerMortensen\Exceptions;

use ErrorException;

class ErrorHandling
{
	/** @var ErrorHandlerInterface */
	private $handler;

	/** @var int */
	private $mask;

	public function __construct(ErrorHandlerInterface $handler, int $mask = E_ALL)
	{
		$this->handler = $handler;
		$this->mask = $mask;

		set_error_handler([$this, 'onError']);
		set_exception_handler([$this->handler, 'handleThrowable']);
		register_shutdown_function([$this, 'onShutdown']);

		// This is necessary to suppress the default output when handling
		// a fatal error. We allow the user to control the output.
		error_reporting(0);
	}

	public function onError(int $level, string $message, string $file, string $line)
	{
		error_clear_last();

		if (self::getErrorException($this->mask, $level, $message, $file, $line, $exception)) {
			throw $exception;
		}
	}

	public function onShutdown()
	{
		$error = error_get_last();

		if (isset($error) && self::getErrorException($this->mask, $error['type'], $error['message'], $error['file'], $error['line'], $exception)) {
			$this->handler->handleThrowable($exception);
		}
	}

	public static function on(int $mask = E_ALL)
	{
		$handler = function (int $level, string $message, string $file, string $line) use ($mask) {
			error_clear_last();

			if (self::getErrorException($mask, $level, $message, $file, $line, $exception)) {
				throw $exception;
			}
		};

		set_error_handler($handler);
	}

	public static function off()
	{
		restore_error_handler();
	}

	private static function getErrorException(int $mask, int $level, string $message, string $file, string $line, ErrorException &$exception = null): bool
	{
		if (($level & $mask) === 0) {
			return false;
		}

		$message = trim($message);
		$code = null;

		$exception = new ErrorException($message, $code, $level, $file, $line);
		return true;
	}
}
