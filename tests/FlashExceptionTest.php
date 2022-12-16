<?php


namespace Neoflow\Flash\Test;

use Middlewares\Utils\Dispatcher;
use Neoflow\Flash\Exception\FlashException;
use Neoflow\Flash\Flash;
use Neoflow\Flash\Middleware\FlashMiddleware;
use PHPUnit\Framework\TestCase;

class FlashExceptionTest extends TestCase
{
    public function testLoadInvalid(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Load values from storage failed. Key "_flash" for values found, but it is not an array.');

        $invalidStorage = [
            '_flash' => 'foo bar'
        ];
        (new Flash())->load($invalidStorage);
    }

    public function testLoadSessionInvalid(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Load values from session not possible. Session not started yet.');

        $flash = new Flash('_flash');

        Dispatcher::run([
            new FlashMiddleware($flash),
        ]);
    }
}
