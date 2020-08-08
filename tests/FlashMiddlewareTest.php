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
                'group1' => [
                    '1 Message A'
                ]
        ];

        $flash = new Flash('_flashMessages');

        Dispatcher::run([
            new FlashMiddleware($flash),
        ]);

        $this->assertSame([
            'group1' => [
                '1 Message A'
            ]
        ], $flash->getCurrent());
        $this->assertSame($_SESSION['_flashMessages'], $flash->getNext());
        $this->assertSame([], $_SESSION['_flashMessages']);
    }
}
