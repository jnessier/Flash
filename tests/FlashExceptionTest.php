<?php


namespace Neoflow\FlashMessages\Test;

use Middlewares\Utils\Dispatcher;
use Neoflow\FlashMessages\Exception\FlashException;
use Neoflow\FlashMessages\Flash;
use Neoflow\FlashMessages\Middleware\FlashMiddleware;
use PHPUnit\Framework\TestCase;

class FlashExceptionTest extends TestCase
{
    public function testLoadInvalid(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Load messages from storage failed. Key "_flashMessages" for flash messages found, but value is not an array.');

        $invalidStorage = [
            '_flashMessages' => 'foo bar'
        ];
        (new Flash())->load($invalidStorage);
    }

    public function testLoadSessionInvalid(): void {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('oad messages from session not possible. Session not started yet.');

        $flash = new Flash('_flashMessages');

        Dispatcher::run([
            new FlashMiddleware($flash),
        ]);
    }

}
