<?php


namespace Neoflow\Flash\Test;

use ArrayObject;
use Neoflow\Flash\Flash;
use Neoflow\Flash\FlashInterface;
use PHPUnit\Framework\TestCase;

class FlashTest extends TestCase
{
    /**
     * @var FlashInterface
     */
    protected $flash;

    protected function setUp(): void
    {
        $this->flash = new Flash('_flash');

        $_SESSION['_flash'] = [
            'messages' => [
                '1 Message A',
                '1 Message B'
            ],
            'key' => 'value'
        ];

        $this->flash->load($_SESSION);
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

    public function testGet(): void
    {
        $this->assertSame([
            '1 Message A',
            '1 Message B'
        ], $this->flash->get('messages'));

        $this->assertSame('Default message', $this->flash->get('key-dont-exist', 'Default message'));
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

    public function testSet(): void
    {
        $this->flash->set('key', 'value');

        $this->assertSame([
            'key' => 'value'
        ], $this->flash->getNext());
    }

    public function testRemove(): void
    {
        $this->flash->set('key', 'value');

        $this->flash->remove('key');

        $this->assertSame([], $this->flash->getNext());
    }

    public function testHas(): void
    {
        $this->assertFalse($this->flash->has('key-dont-exist'));
    }

    public function testKeep(): void
    {
        $this->flash->keep();

        $this->assertSame([
            'messages' => [
                '1 Message A',
                '1 Message B'
            ],
            'key' => 'value'
        ], $this->flash->getNext());
    }

    public function testSetCurrent(): void
    {
        $this->flash->setCurrent([
            'keyCurret' => 'valueCurrent'
        ]);

        $this->assertSame([
            'keyCurret' => 'valueCurrent'
        ], $this->flash->getCurrent());
    }

    public function testSetNext(): void
    {
        $this->flash->setNext([
            'key' => 'value'
        ]);

        $this->assertSame([
            'key' => 'value'
        ], $this->flash->getNext());
    }
}
