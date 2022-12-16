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
            'group1' => [
                '1 Message A',
                '1 Message B'
            ],
            'group2' => []
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
        ], $this->flash->get('group1'));

        $this->assertSame([
            'Default message'
        ],
            $this->flash->get('group9', [
                'Default message'
            ])
        );
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
        $this->flash->set('group1', '1 Message A');

        $next = $this->flash->getNext();

        $this->assertTrue(isset($next['group1']));
    }

    public function testRemove(): void
    {
        $this->flash->set('group1', '1 Message A');

        $this->flash->remove('group1');

        $next = $this->flash->getNext();

        $this->assertFalse(isset($next['group1']));
    }

    public function testHas(): void
    {
        $this->assertFalse($this->flash->has('group9'));
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
        ], $_SESSION['_flash']);
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

        $this->assertSame($_SESSION['_flash'], $this->flash->getNext());
    }
}
