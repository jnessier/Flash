<?php

namespace Neoflow\FlashMessages\Test;

use Middlewares\Utils\Dispatcher;
use Neoflow\FlashMessages\Flash;
use Neoflow\FlashMessages\Middleware\FlashMiddleware;
use PHPUnit\Framework\TestCase;

class FlashMiddlewareTest extends TestCase
{
    public function test(): void
    {
        $_SESSION['_flashMessages'] = [
            'm1' => [
                '1 Message A'
            ]
        ];

        $flash = new Flash('_flashMessages');

        Dispatcher::run([
            new FlashMiddleware($flash),
        ]);

        $flash->addMessage('m1', '1 Message Special A');

        $this->assertSame('1 Message A', $flash->getFirstMessage('m1'));
        $this->assertSame($_SESSION['_flashMessages'], $flash->getNextMessages()->toArray());
    }
}
