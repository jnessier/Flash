# FlashMessages
[![Build Status](https://travis-ci.org/Neoflow/FlashMessages.svg?branch=master&service=github)](https://travis-ci.org/Neoflow/FlashMessages)
[![Coverage Status](https://coveralls.io/repos/github/Neoflow/FlashMessages/badge.svg?branch=master&service=github)](https://coveralls.io/github/Neoflow/FlashMessages?branch=master)
[![Latest Stable Version](https://poser.pugx.org/neoflow/flash-messages/v?service=github)](https://packagist.org/packages/neoflow/flash-messages)
[![Total Downloads](https://poser.pugx.org/neoflow/flash-messages/downloads?service=github)](//packagist.org/packages/neoflow/flash-messages)
[![License](https://poser.pugx.org/neoflow/flash-messages/license?service=github)](https://packagist.org/packages/neoflow/flash-messages)

Flash messages service for Slim 4 and similar PSR-15 compliant frameworks or apps.

## Table of Contents
- [Requirement](#requirement)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributors](#contributors)
- [History](#history)
- [License](#license)

## Requirement
* PHP >= 7.3

## Installation
You have 2 options to install this library.

Via Composer...
```bash
composer require neoflow/flash-messages
```

...or manually add this line to the `require` block in your `composer.json`:
```json
"neoflow/flash-messages": "^0.0.1"
```

## Configuration
The following instructions based on [Slim 4](http://www.slimframework.com), in combination with [PHP-DI](https://php-di.org), but should be adaptable for 
any PSR-11/PSR-15 compliant frameworks and libraries.

Add the service `Neoflow\FlashMessages\Flash` and middleware `Neoflow\FlashMessages\FlashMiddleware`
 to the container definitions...
```php
use Neoflow\FlashMessages\Flash;
use Neoflow\FlashMessages\FlashInterface;
use Neoflow\FlashMessages\Middleware\FlashMiddleware;
use Psr\Container\ContainerInterface;

return [
    // ...
    FlashInterface::class => function () {
        $key = '_flashMessages'; // Optional, key as identifier of the flash messages
        return new Flash($key);
    },
    FlashMiddleware::class => function (ContainerInterface $container) {
        $flash = $container->get(FlashInterface::class);
        return new FlashMiddleware($flash);
    },
    // ...
];
```
...and register the middleware, to load the session as storage for the messages. 
```php
use Neoflow\FlashMessages\Middleware\FlashMiddleware;

$app->add(FlashMiddleware::class);
```
**Please note** The session has to start first, before the middleware can get successfully dispatched. 

Alternatively, you can also load the storage of the flash messages with a closure middleware from another source than
 the session...
```php
$app->add(function ($request, $handler) use ($container) {
    $storage = [
        '_flashMessages' => []
    ]; // Storage of the flash messages
    $container->get(FlashInterface::class)->loadMessages($storage);
    return $handler->handle($request);
});
```
...or add it directly in the container definitions and skip the middleware.
```php
use Neoflow\FlashMessages\Flash;
use Neoflow\FlashMessages\FlashInterface;

return [
    // ...
    FlashInterface::class => function () {
        $key = '_flashMessages'; // Key as identifier of the flash messages
        $storage = [
            '_flashMessages' => []
        ]; // Storage of the flash messages
        return new Flash($key, $storage);
    },
    // ...
];
```

**Please note** The custom storage has to be an array or ArrayAccess/ArrayObject-implementation. 

When your DI container supports inflectors (e.g. [league/container](https://container.thephpleague.com/3.x/inflectors/)),
 you can optionally register `Neoflow/FlashMessages/FlashAwareInterface` as inflector to your container definition.

Additionally, you can also use `Neoflow/FlashMessages/FlashAwareTrait` as a shorthand implementation of
 `Neoflow/FlashMessages/FlashAwareInterface`.

## Usage
tbd
  
## Contributors
* Jonathan Nessier, [Neoflow](https://www.neoflow.ch)

If you would like to see this library develop further, or if you want to support me or show me your appreciation, please
 donate any amount through PayPal. Thank you! :beers:
 
[![Donate](https://img.shields.io/badge/Donate-paypal-blue)](https://www.paypal.me/JonathanNessier)

## History
Slim offers with [Slim-Flash](https://github.com/slimphp/Slim-Flash) as standalone library for flash
 messages.
Unfortunately the library looks a little bit abandoned on GitHub, has no interfaces implemented and doesn't support a 
 complete set of methods to access and manipulate both types of the messages (from current and for the next
  request). 
This circumstance led me to develop this PSR-15 compliant flash messages service for Slim 4.
Inspired by the slimness of the framework itself.

## License
Licensed under [MIT](LICENSE). 

*Made in Switzerland with :cheese: and :heart:*