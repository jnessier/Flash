# Flash
[![Build Status](https://github.com/neoflow/flash/workflows/Tests/badge.svg)](https://github.com/neoflow/flash/actions?query=branch:4.x)
[![Latest Stable Version](https://poser.pugx.org/neoflow/flash/v?service=github)](https://packagist.org/packages/neoflow/flash)
[![Total Downloads](https://poser.pugx.org/neoflow/flash/downloads?service=github)](//packagist.org/packages/neoflow/flash)
[![License](https://poser.pugx.org/neoflow/flash/license?service=github)](https://packagist.org/packages/neoflow/flash)

Flash service for Slim 4 and similar [PSR-15](https://www.php-fig.org/psr/psr-15/) compliant frameworks and apps.

## Table of Contents
- [Requirement](#requirement)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Session](#session)
- [Contributors](#contributors)
- [History](#history)
- [License](#license)

## Requirement
* PHP >= 7.3

## Installation
You have 2 options to install this library.

Via Composer...
```bash
composer require neoflow/flash
```
...or manually download the latest release from [here](https://github.com/Neoflow/Session/releases/).

## Configuration
The following instructions based on [Slim 4](http://www.slimframework.com), in combination with
 [PHP-DI](https://php-di.org), but should be adaptable for any PSR-11/PSR-15 compliant frameworks and libraries.

Add the service `Neoflow\Flash\Flash` and middleware `Neoflow\Flash\Middleware\FlashMiddleware`
 to the container definitions...
```php
use Neoflow\Flash\Flash;
use Neoflow\Flash\FlashInterface;
use Neoflow\Flash\Middleware\FlashMiddleware;
use Psr\Container\ContainerInterface;

return [
    // ...
    FlashInterface::class => function () {
        $key = '_flash'; // Key as identifier of the values in the storage
        return new Flash($key);
    },
    FlashMiddleware::class => function (ContainerInterface $container) {
        $flash = $container->get(FlashInterface::class);
        return new FlashMiddleware($flash);
    },
    // ...
];
```
...and register the middleware, to use the session as storage for the values. 
```php
use Neoflow\Flash\Middleware\FlashMiddleware;

$app->add(FlashMiddleware::class);
```
**Please note** The session has to start first, before the middleware can get successfully dispatched. 

Alternatively, you can also load values from another storage than the session with a closure middleware...
```php
$app->add(function ($request, $handler) use ($container) {
    $storage = [ 
        // Your custom storage of the values
    ];
    $container->get(FlashInterface::class)->load($storage);
    return $handler->handle($request);
});
```
...or add it directly in the container definitions and skip the middleware.
```php
use Neoflow\Flash\Flash;
use Neoflow\Flash\FlashInterface;

return [
    // ...
    FlashInterface::class => function () {
        $key = '_flash'; // Key as identifier of the values in the storage
        $storage = [
            // Your custom storage of the values
        ];
        return new Flash($key, $storage);
    },
    // ...
];
```

When your DI container supports inflectors (e.g. [league/container](https://container.thephpleague.com/3.x/inflectors/)),
 you can optionally register `Neoflow/Flash/FlashAwareInterface` as inflector to your container definition.

Additionally, you can also use `Neoflow/Flash/FlashAwareTrait` as a shorthand implementation of
 `Neoflow/Flash/FlashAwareInterface`.

## Usage
The service `Neoflow\Flash\Flash` provides the most needed methods to get access to the values for the
 current request and to add values for the next request.
```php
// Set a value by key for the next request.
$key = 'key'; // Key as identifier of the value
$flash = $flash->set($key, 'Your custom value');

// Get value by key, set for current request.
$default = null; // Default value, when value doesn't exists or is empty (default: null)
$value = $flash->get($key, $default);

// Check whether value by key for current request exists.
$exists = $flash->has($key);

// Count number of values for current request.
$numberOfValues = $flash->count();

// Clear values of current and next request.
$flash = $flash->clear();

// Keep current values for next request. Existing values will be overwritten.
$flash = $flash->keep(); 

// Load values from storage as reference.
$storage = [
    '_flash' => []
];
$flash = $flash->load($storage);
```

For more advanced use cases, you can also get and set the values for current and next request.
```php
// Get values set for next request.
$nextValues = $flash->getNext();

// Set values for next request. Existing values will be overwritten.
$flash = $flash->setNext([
    'key1' => 'value1'
]);

// Get values set for current request.
$currentValues = $flash->getCurrent();

// Set values for current request. Existing values will be overwritten.
$flash = $flash->setCurrent([
    'key1' => 'value1'
]);
```

## Nice to know
Version 2.0 has been simplified and the message handling implementation has been removed. If you need the message
 handling please keep using version 1.2.

In earlier times, the library was also part of [Neoflow\Session](https://github.com/Neoflow/Session) and then moved 
 into a standalone library, to comply with the design principle of separation of concerns.

If you want to use a session service, you can easily combine both libraries as composer packages. 
The integration and usage of [Neoflow\Session](https://github.com/Neoflow/Session) is very similar to the
 current library.
  
## Contributors
* Jonathan Nessier, [Neoflow](https://www.neoflow.ch)

If you would like to see this library develop further, or if you want to support me or show me your appreciation, please
 donate any amount through PayPal. Thank you! :beers:
 
[![Donate](https://img.shields.io/badge/Donate-paypal-blue)](https://www.paypal.me/JonathanNessier)

## License
Licensed under [MIT](LICENSE). 

*Made in Switzerland with :cheese: and :heart:*
