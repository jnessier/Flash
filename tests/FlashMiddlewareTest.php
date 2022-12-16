<?php

namespace Neoflow\Flash\Test;

use Middlewares\Utils\Dispatcher;
use Neoflow\Flash\Flash;
use Neoflow\Flash\Middleware\FlashMiddleware;
use PHPUnit\Framework\TestCase;

class FlashMiddlewareTest extends TestCase
{
    public function test(): void
    {
        $_SESSION['_flash'] = [
                'group1' => [
                    '1 Message A'
                ]
        ];

        $flash = new Flash('_flash');

        Dispatcher::run([
            new FlashMiddleware($flash),
        ]);

        $this->assertSame([
            'group1' => [
                '1 Message A'
            ]
        ], $flash->getCurrent());
        $this->assertSame($_SESSION['_flash'], $flash->getNext());
        $this->assertSame([], $_SESSION['_flash']);
    }
}
