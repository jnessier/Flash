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
        $this->expectExceptionMessage('Load messages from storage failed. Key "_flashMessages" for flash messages found, but value is not an array.');

        $invalidStorage = [
            '_flashMessages' => 'foo bar'
        ];
        (new Flash())->loadMessages($invalidStorage);
    }

    public function testInvalidMessagesLoadFromSession(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Load messages from session failed. Session not started yet.');

        unset($_SESSION);
        (new Flash())->loadMessagesFromSession();
    }

    public function testInvalidStorageLoad(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Load messages from storage failed. Storage must be an array or an ArrayAccess (or ArrayObject) implementation.');

        $invalidStorage = 'foo bar';
        (new Flash())->loadMessages($invalidStorage);
    }

    public function testNotLoadedCurrentMessages(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Messages for current request does not exists. Messages not loaded from storage yet.');

        (new Flash())->getCurrentMessages();
    }

    public function testNotLoadedNextMessages(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Messages for next request does not exists. Messages not loaded from storage yet.');

        (new Flash())->getNextMessages();
    }
}
