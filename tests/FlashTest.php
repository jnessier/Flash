<?php


namespace Neoflow\FlashMessages\Test;

use ArrayObject;
use InvalidArgumentException;
use Neoflow\FlashMessages\Exception\FlashException;
use Neoflow\FlashMessages\Flash;
use Neoflow\FlashMessages\Messages;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class FlashTest extends TestCase
{
    /**
     * @var Flash
     */
    protected $flash;

    protected function setUp(): void
    {
        $this->flash = new Flash('_flashMessages');

        $_SESSION['_flashMessages'] = [
            'm1' => [
                '1 Message A',
                '1 Message B'
            ],
            'm2' => []
        ];

        $this->flash->loadMessagesFromSession();
    }

    public function testAddMessage(): void
    {
        $this->flash->addMessage('m1', '1 Message A');

        $this->assertSame([
            'm1' => [
                '1 Message A',
            ],
        ], $this->flash->getNextMessages()->toArray());
    }

    public function testDirectStorageLoad(): void
    {
        $storage = new ArrayObject([
            '_flashMessages' => [
                'm1' => [
                    '1 Message A'
                ]
            ]
        ]);

        $flash = new Flash('_flashMessages', $storage);

        $this->assertSame([
            'm1' => [
                '1 Message A'
            ]
        ], $flash->getCurrentMessages()->toArray());

        $this->assertSame([
            '_flashMessages' => []
        ], $storage);
    }

    public function testGetCurrentMessages(): void
    {
        $this->assertSame([
            'm1' => [
                '1 Message A',
                '1 Message B'
            ],
            'm2' => []
        ], $this->flash->getCurrentMessages()->toArray());
    }

    public function testGetFirstMessage(): void
    {
        $this->assertSame('1 Message A', $this->flash->getFirstMessage('m1'));
    }

    public function testGetLastMessage(): void
    {
        $this->assertSame('1 Message B', $this->flash->getLastMessage('m1'));
    }

    public function testGetMessages(): void
    {
        $this->assertSame([
            '1 Message A',
            '1 Message B'
        ], $this->flash->getMessages('m1'));
    }

    public function testGetNextMessages(): void
    {
        $this->assertSame([], $this->flash->getNextMessages()->toArray());
    }

    public function testInvalidMessagesFromStorageLoad(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Loading storage failed. Key "_flashMessages" for flash messages found, but value is not an array.');

        $invalidStorage = [
            '_flashMessages' => 'foo bar'
        ];
        $this->flash->loadMessages($invalidStorage);
    }

    public function testInvalidMessagesLoadFromSession(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Loading storage from session failed. Session not started yet.');

        unset($_SESSION);
        $this->flash->loadMessagesFromSession();
    }

    public function testInvalidStorageLoad(): void
    {
        $this->expectException(FlashException::class);
        $this->expectExceptionMessage('Loading storage failed. Storage must be an array or an ArrayAccess (or ArrayObject) implementation.');

        $invalidStorage = 'foo bar';
        $this->flash->loadMessages($invalidStorage);
    }

    public function testKeepMessages(): void
    {
        $this->flash->keepMessages();

        $this->assertSame([
            'm1' => [
                '1 Message A',
                '1 Message B'
            ],
            'm2' => []
        ], $this->flash->getNextMessages()->toArray());
    }
}