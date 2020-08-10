# FlashMessages
[![Build Status](https://travis-ci.org/Neoflow/FlashMessages.svg?branch=master&service=github)](https://travis-ci.org/Neoflow/FlashMessages)
[![Coverage Status](https://coveralls.io/repos/github/Neoflow/FlashMessages/badge.svg?branch=master&service=github)](https://coveralls.io/github/Neoflow/FlashMessages?branch=master)
[![Latest Stable Version](https://poser.pugx.org/neoflow/flash-messages/v?service=github)](https://packagist.org/packages/neoflow/flash-messages)
[![Total Downloads](https://poser.pugx.org/neoflow/flash-messages/downloads?service=github)](//packagist.org/packages/neoflow/flash-messages)
[![License](https://poser.pugx.org/neoflow/flash-messages/license?service=github)](https://packagist.org/packages/neoflow/flash-messages)

Flash message service for Slim 4 and similar [PSR-15](https://www.php-fig.org/psr/psr-15/) compliant frameworks and apps.

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
composer require neoflow/flash-messages
```
...or manually download the latest release from [here](https://github.com/Neoflow/Session/releases/).

## Configuration
The following instructions based on [Slim 4](http://www.slimframework.com), in combination with
 [PHP-DI](https://php-di.org), but should be adaptable for any PSR-11/PSR-15 compliant frameworks and libraries.

Add the service `Neoflow\FlashMessages\Flash` and middleware `Neoflow\FlashMessages\Middleware\FlashMiddleware`
 to the container definitions...
```php
use Neoflow\FlashMessages\Flash;
use Neoflow\FlashMessages\FlashInterface;
use Neoflow\FlashMessages\Middleware\FlashMiddleware;
use Psr\Container\ContainerInterface;

return [
    // ...
    FlashInterface::class => function () {
        $key = '_flashMessages'; // Key as identifier of the messages in the storage
        return new Flash($key);
    },
    FlashMiddleware::class => function (ContainerInterface $container) {
        $flash = $container->get(FlashInterface::class);
        return new FlashMiddleware($flash);
    },
    // ...
];
```
...and register the middleware, to use the session as storage for the messages. 
```php
use Neoflow\FlashMessages\Middleware\FlashMiddleware;

$app->add(FlashMiddleware::class);
```
**Please note** The session has to start first, before the middleware can get successfully dispatched. 

Alternatively, you can also load messages from another storage than the session with a closure middleware...
```php
$app->add(function ($request, $handler) use ($container) {
    $storage = [ 
        // Your custom storage of the messages
    ];
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
        $key = '_flashMessages'; // Key as identifier of the messages in the storage
        $storage = [
            // Your custom storage of the messages
        ];
        return new Flash($key, $storage);
    },
    // ...
];
```

When your DI container supports inflectors (e.g. [league/container](https://container.thephpleague.com/3.x/inflectors/)),
 you can optionally register `Neoflow/FlashMessages/FlashAwareInterface` as inflector to your container definition.

Additionally, you can also use `Neoflow/FlashMessages/FlashAwareTrait` as a shorthand implementation of
 `Neoflow/FlashMessages/FlashAwareInterface`.

## Usage
The service `Neoflow\FlashMessages\Flash` provides the most needed methods to get access to the messages for the
 current request and to add messages for the next request.
```php
// Add message to a message group by key for next request.
$key = 'key'; // Key as identifier of the message group
$flash = $flash->addMessage($key, 'Your custom message');

// Get message group by key, set for current request.
$default = []; // Default value, when message group doesn't exists or is empty (default: [])
$messages = $flash->getMessages($key, $default);

// Check whether message group by key exists.
$exists = $flash->hasMessages($key);

// Count number of messages of a message group by key, set for current request.
$numberOfMessages = $flash->countMessages($key);

// Get first message from a message group by key, set for current request.
$default = null; // Default value, when message group doesn't exists or is empty (default: null)
$firstMessage = $flash->getFirstMessage('key', $default);

// Get last message from a message group by key, set for current request.
$lastMessage = $flash->getLastMessage('key', $default);

// Clear messages of current and next request.
$flash = $flash->clear();

// Keep current message groups for next request. Existing message groups will be overwritten.
$flash = $flash->keep(); 

// Load messages from storage as reference.
$storage = [
    '_flashMessages' => []
];
$flash = $flash->load($storage);
```

For more advanced use cases, you can also get and set the messages groups for current and next request.
```php
// Get message groups, set for next request.
$nextMessageGroups = $flash->getNext();

// Set message groups for next request. Existing message groups will be overwritten.
$flash = $flash->setNext($nextMessageGroups);

// Get message groups, set for current request.
$currentMessageGroups = $flash->getCurrent();

// Set message groups for current request. Existing message groups will be overwritten.
$flash = $flash->setCurrent($currentMessageGroups);
```

## Session
In earlier times, this library was part of [Neoflow\Session](https://github.com/Neoflow/Session) and the moved into a
 standalone library, to comply with the design principle of separation of concerns.

If you want to use a session service, you can easily combine both libraries as composer packages. 
The integration and usage of [Neoflow\Session](https://github.com/Neoflow/Session) is very similar to the
 current library.
  
## Contributors
* Jonathan Nessier, [Neoflow](https://www.neoflow.ch)

If you would like to see this library develop further, or if you want to support me or show me your appreciation, please
 donate any amount through PayPal. Thank you! :beers:
 
[![Donate](https://img.shields.io/badge/Donate-paypal-blue)](https://www.paypal.me/JonathanNessier)

## History
Slim offers with [Slim-Flash](https://github.com/slimphp/Slim-Flash) as standalone library for flash
 messages.
Unfortunately the library looks a little bit abandoned on GitHub, has no interfaces implemented and doesn't provide a 
 complete set of methods to access and manipulate both types of messages.
This circumstance led me to develop this PSR-15 compliant flash messages service for Slim 4.
Inspired by the slimness of the framework itself.

## License
Licensed under [MIT](LICENSE). 

*Made in Switzerland with :cheese: and :heart:*