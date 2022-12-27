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
use Throwable;

class ErrorHandling
{
	/** @var Handler */
	private $handler;

	/** @var int */
	private $mask;

	public function __construct (Handler $handler, int $mask = E_ALL, $customOutput = true)
	{
		$this->handler = $handler;
		$this->mask = $mask;

		// Handle any uncaught Throwable object that bubbles up to the global scope
		set_exception_handler([$handler, 'handle']);

		// Handle any fatal error that otherwise could not be caught
		register_shutdown_function([$this, 'shutdown']);

		// Convert uncatchable errors to catchable ErrorException objects
		self::on($mask);

		// Suppress the default stderr output, so we can control it ourselves
		if ($customOutput) {
			error_reporting(0);
		}
	}

	public function shutdown ()
	{
		$error = error_get_last();

		if (is_array($error) && (($error['type'] & $this->mask) !== 0)) {
			$exception = new ErrorException(trim($error['message']), 0, $error['type'], $error['file'], $error['line']);
			$this->handler->handle($exception);
		}
	}

	public static function on (int $mask = E_ALL)
	{
		$onError = function (int $level, string $message, string $file, string $line) use ($mask)
		{
			error_clear_last();

			if (($level & $mask) !== 0) {
				throw new ErrorException(trim($message), 0, $level, $file, $line);
			}
		};

		set_error_handler($onError);
	}

	public static function off ()
	{
		restore_error_handler();
	}
}
