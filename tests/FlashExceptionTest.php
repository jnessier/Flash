<?php


namespace Neoflow\FlashMessages\Test;

use ArrayObject;
use InvalidArgumentException;
use Neoflow\FlashMessages\Exception\FlashException;
use Neoflow\FlashMessages\Flash;
use Neoflow\FlashMessages\Messages;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class FlashExceptionTest extends TestCase
{
    public function testInvalidMessagesFromStorageLoad(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Loading storage failed. Key "_flashMessages" for flash messages found, but value is not an array.');

        $invalidStorage = [
            '_flashMessages' => 'foo bar'
        ];
        (new Flash())->loadMessages($invalidStorage);
    }

    public function testInvalidMessagesLoadFromSession(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Loading storage from session failed. Session not started yet.');

        unset($_SESSION);
        (new Flash())->loadMessagesFromSession();
    }

    public function testInvalidStorageLoad(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Loading storage failed. Storage must be an array or an ArrayAccess (or ArrayObject) implementation.');

        $invalidStorage = 'foo bar';
        (new Flash())->loadMessages($invalidStorage);
    }
}
