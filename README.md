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
        $key = '_flashMessages'; // Key as identifier of the flash messages
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

Alternatively, you can also load the storage of the flash messages with a closure middleware from another source than
 the session...
```php
$app->add(function ($request, $handler) use ($container) {
    $storage = [ // Flash messages storage
        '_flashMessages' => []
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
        $key = '_flashMessages'; // Key as identifier of the flash messages
        $storage = [ // Flash messages storage
            '_flashMessages' => []
        ];
        return new Flash($key, $storage);
    },
    // ...
];
```

**Please note** The storage has to be an array or an ArrayAccess-implementation. 

When your DI container supports inflectors (e.g. [league/container](https://container.thephpleague.com/3.x/inflectors/)),
 you can optionally register `Neoflow/FlashMessages/FlashAwareInterface` as inflector to your container definition.

Additionally, you can also use `Neoflow/FlashMessages/FlashAwareTrait` as a shorthand implementation of
 `Neoflow/FlashMessages/FlashAwareInterface`.

## Usage
The service `Neoflow\FlashMessages\Flash` provides the most needed methods to access the messages for the
 current request and to add the messages for the next request.
```php
// Add message by key for the next request.
$flash = $flash->addMessage('key', 'Your message.');

// Get messages by key, set for the current request.
$messages = $flash->getMessages('key');

// Get first message by key, set for the current request, or default when no message exists.
$default = []; // Optional (default: null)
$firstMessage = $flash->getLastMessage('key', $default);

// Get last message by key, set for the current request, or default when no message exists.
$default = []; // Optional (default: null)
$lastMessage = $flash->getLastMessage('key', $default);

// Keep messages, set for the current request, for the next request too.  
// Note: Already added messages will be overwritten.
$flash = $flash->keepMessages(); 

// Load messages from storage as reference.
$storage = [
    '_flashMessages' => []
];
$flash = $flash->loadMessages($storage);

// Load messages from session ($_SESSION).
$flash = $flash->loadMessagesFromSession();
```

You can also get the handler `Neoflow\FlashMessages\Messages` for each messages type.
```php
// Get handler with messages, set for the next request. Returns `Neoflow\FlashMessages\Messages`.
$handler = $flash->getNextMessages();
  
// Get handler with messages, set for the current request. Returns `Neoflow\FlashMessages\Messages`.
$handler = $flash->getCurrentMessages();
```

The handler provides a complete set of methods to access and manipulate the messages.
```php
// Add message by key.
$handler = $handler->add('key', 'Your messages');

// Clear messages by key.
$handler->clear('key');

// Clear all messages.
$handler->clearAll();

// Count number of messages by key.
$numberOfMessages = $handler->count('key');

// Get messages by key, or default value when no message exists.
$default = []; // Optional (default: [])
$messages = $handler->get('key', $default);

// Get all messages.
$messages = $handler->getAll();

// Get first message by key, or default value when no message exists.
$default = 'Default first message'; // Optional (default: null)
$firstMessage = $handler->getFirst('key', $default);

// Get last message by key, or default value when no message exists.
$default = 'Default last message'; // Optional (default: null)
$lastMessage = $handler->getLast('key', $default);
    
// Check whether messages by key exists.
$keyExists = $handler->has('key');

// Set messages. Already set messages will be overwritten.
$handler = $handler->set([
    'key' => [
        'Your message'
    ]
]);

// Set referenced messages. Already set messages will be overwritten.
$messages = [
    'key' => [
        'Your message'
    ]
];
$handler = $handler->setReference($messages);
``` 
  
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