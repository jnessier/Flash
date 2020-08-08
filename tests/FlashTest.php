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
            'group1' => [
                '1 Message A',
                '1 Message B'
            ],
            'group2' => []
        ];

        $this->flash->load($_SESSION);
    }

    public function testAddMessage(): void
    {
        $this->flash->addMessage('group1', '1 Message A');

        $this->assertSame($_SESSION['_flashMessages'], $this->flash->getNext());
    }

    public function testDirectStorageLoad(): void
    {
        $storage = [
            '_foobarKey' => [
                'Message A'
            ]
        ];

        $flash = new Flash('_foobarKey', $storage);

        $this->assertSame([
            'Message A'
        ], $flash->getCurrent());

        $this->assertSame([
            '_foobarKey' => []
        ], $storage);
    }

    public function testGetFirstMessage(): void
    {
        $this->assertSame('1 Message A', $this->flash->getFirstMessage('group1'));
        $this->flash->clear();
        $this->assertSame('default', $this->flash->getFirstMessage('group1', 'default'));
    }

    public function testGetLastMessage(): void
    {
        $this->assertSame('1 Message B', $this->flash->getLastMessage('group1'));
        $this->flash->clear();
        $this->assertSame('default', $this->flash->getLastMessage('group1', 'default'));
    }

    public function testGetMessages(): void
    {
        $this->assertSame([
            '1 Message A',
            '1 Message B'
        ], $this->flash->getMessages('group1'));

        $this->assertSame([
            'Default message'
        ], $this->flash->getMessages('group9', [
            'Default message'
        ]));
    }

    public function testGetNext(): void
    {
        $this->assertSame([], $this->flash->getNext());
    }

    public function testClear(): void
    {
        $this->flash->clear();

        $this->assertSame([], $this->flash->getCurrent());
        $this->assertSame([], $this->flash->getNext());
    }


    public function testHasMessage(): void
    {
        $this->flash->addMessage('group1', '1 Message A');

        $this->assertTrue($this->flash->hasMessages('group1'));
        $this->assertFalse($this->flash->hasMessages('group9'));
    }

    public function testKeep(): void
    {
        $this->flash->keep();

        $this->assertSame([
            'group1' => [
                '1 Message A',
                '1 Message B'
            ],
            'group2' => []
        ], $_SESSION['_flashMessages']);
    }

    public function testSetCurrent(): void
    {
        $this->flash->setCurrent([
            'group9' => [
                '9 Message Z'
            ]
        ]);

        $this->assertSame([
            'group9' => [
                '9 Message Z'
            ]
        ], $this->flash->getCurrent());
    }

    public function testSetNext(): void
    {
        $this->flash->setNext([
            'group9' => [
                '9 Message Z'
            ]
        ]);

        $this->assertSame($_SESSION['_flashMessages'], $this->flash->getNext());
    }
}
