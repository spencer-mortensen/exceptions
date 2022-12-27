# Exceptions

This project is available as a Composer Package:   
[spencer-mortensen/exceptions](https://packagist.org/packages/spencer-mortensen/exceptions)

## Overview

Error handling in PHP is [complicated](https://spencermortensen.com/articles/php-error-handling/), but this library makes it bullet-proof:
Create a method to handle exceptions (e.g. `$handler->handle($throwable);`) and you're good to go!

This library converts all PHP notices, warnings, and errors into exceptions, so you can handle them.
It also works on any thrown exceptions that make it up to the global scope.
It even catches most of the fatal errors, which would otherwise be impossible to handle.


## Usage

Example 1. Enable error handling for the entire program:

```php
new ErrorHandling($errorHandler, E_ALL);
```

Example 2. Enable error handling ONLY for a portion of the code (useful when you're writing a library):

```php
try {
	ErrorHandling::on();
	...
} finally {
	ErrorHandling::off();
}
```

This converts PHP notices, warnings, and errors into catchable exceptions, but _only_ for the duration of the try/catch block.

Example 3. Show the built-in PHP STDERR messages, so you can see errors while you're working on your error handler.

```php
new ErrorHandling($errorHandler, E_ALL, false);
```

See the example area for working code and ideas.