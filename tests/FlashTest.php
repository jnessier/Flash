<?php


namespace Neoflow\FlashMessages\Test;

use ArrayObject;
use Neoflow\FlashMessages\Flash;
use Neoflow\FlashMessages\FlashInterface;
use PHPUnit\Framework\TestCase;

class FlashTest extends TestCase
{
    /**
     * @var FlashInterface
     */
    protected $flash;

    protected function setUp(): void
    {
        $this->flash = new Flash('_flashMessages');

        $_SESSION['_flashMessages'] = [
            'Message A',
            'Message B'
        ];

        $this->flash->loadFromSession();
    }

    public function testAddMessage(): void
    {
        $this->flash->addMessage('1 Message A');

        $this->assertSame([
            '1 Message A'
        ], $this->flash->getNextMessages());
    }

    public function testDirectStorageLoad(): void
    {
        $storage = [
            '_foobarKey' => [
                    '1 Message A'
            ]
        ];

        $flash = new Flash('_foobarKey', $storage);

        $this->assertSame([
                '1 Message A'
        ], $flash->getMessages());

        $this->assertSame([
            '_foobarKey' => []
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
        ], $this->flash->getCurrentMessages()->getAll());
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
        $this->assertSame([], $this->flash->getNextMessages()->getAll());
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
        ], $_SESSION['_flashMessages']);
    }
}
