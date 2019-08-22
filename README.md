# Exceptions

This project is available as a Composer Package:   
[spencer-mortensen/exceptions](https://packagist.org/packages/spencer-mortensen/exceptions)


## Usage

Example 1. Enable error handling at the beginning of your script:

```php
new ErrorHandling($handler, E_ALL);
```

This converts all PHP notices, warnings, and errors into exceptions and passes them to your handler.
This also works with fatal errors and uncaught exceptions, so you can now handle the ghostly fatal issues that previously went undetected.


Example 2. Build exception handling into your libraries:

```php
try {
	ErrorHandling::on();
	...
} finally {
	ErrorHandling::off();
}
```

This converts PHP notices, warnings, and errors into catchable exceptions, but _only_ for the duration of the try/catch block.
This can be useful if you're writing a library, and would like to use exception handling, but can't alter the global behavior of PHP for your users.


## Unit tests

This project uses the [Lens](http://lens.guide) unit-testing framework.

[![Build Status](https://travis-ci.org/spencer-mortensen/exceptions.png?branch=master)](https://travis-ci.org/spencer-mortensen/exceptions)
