<?php

namespace SpencerMortensen\Exceptions;

use ErrorException;


// Test
Exceptions::setHandler($handler);

// Cause
$handler = function () {};

// Effect
register_shutdown_function(['SpencerMortensen\\Exceptions\\Exceptions', 'onShutdown']); // return null;
set_exception_handler(['SpencerMortensen\\Exceptions\\Exceptions', 'onException']); // return null;


// Test
Exceptions::on();

// Effect
set_error_handler(['SpencerMortensen\\Exceptions\\Exceptions', 'onError']);


// Test
Exceptions::off();

// Effect
restore_error_handler();


// Test
Exceptions::onError($level, $message, $file, $line);

// Cause
$level = 256;
$message = ' Armageddon ';
$file = '/tmp/file.php';
$line = 3;

// Effect
throw new ErrorException('Armageddon', 0, 256, '/tmp/file.php', 3);


// Test
Exceptions::setHandler($handler);
Exceptions::onException($exception);

// Cause
$handler = function ($exception) { echo $exception->getMessage(); };
$exception = new ErrorException('Armageddon');

// Effect
register_shutdown_function(['SpencerMortensen\\Exceptions\\Exceptions', 'onShutdown']); // return null;
set_exception_handler(['SpencerMortensen\\Exceptions\\Exceptions', 'onException']); // return null;
echo 'Armageddon';


// Test
Exceptions::setHandler($handler);
Exceptions::onShutdown();

// Cause
$handler = function ($exception) { throw $exception; };

// Effect
register_shutdown_function(['SpencerMortensen\\Exceptions\\Exceptions', 'onShutdown']); // return null;
set_exception_handler(['SpencerMortensen\\Exceptions\\Exceptions', 'onException']); // return null;
error_get_last(); // return ['message' => ' Armageddon ', 'type' => 256, 'file' => '/tmp/file.php', 'line' => 3];
throw new ErrorException('Armageddon', 0, 256, '/tmp/file.php', 3);

// Cause
$handler = function ($exception) { throw $exception; };

// Effect
register_shutdown_function(['SpencerMortensen\\Exceptions\\Exceptions', 'onShutdown']); // return null;
set_exception_handler(['SpencerMortensen\\Exceptions\\Exceptions', 'onException']); // return null;
error_get_last(); // return null;
