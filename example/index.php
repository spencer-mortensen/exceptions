<?php

namespace App;

use App\Handlers\MainHandler;
use Exception;
use SpencerMortensen\Exceptions\ErrorHandling;
use SpencerMortensen\Exceptions\Handler;

require __DIR__ . '/bootstrap.php';

$errorHandler = new MainHandler($settings, true);
new ErrorHandling($errorHandler, E_ALL, false);

// ERRORS:

define(Pi, 3.14159265);
// throw new Exception('Armageddon', 666);
