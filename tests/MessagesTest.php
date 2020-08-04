<?php

namespace Neoflow\FlashMessages\Test;

use Neoflow\FlashMessages\Messages;
use PHPUnit\Framework\TestCase;

class MessagesTest extends TestCase
{
    /**
     * @var Messages
     */
    protected $messages;

    protected function setUp(): void
    {
        $this->messages = Messages::create([
            'm1' => [
                '1 Message A',
            ],
            'm2' => []
        ]);
    }

    public function testAdd(): void
    {
        $this->messages->add('m1', '1 Message B');
        $this->messages->add('m2', '2 Message A');
        $this->messages->add('m3', '3 Message A');

        $this->assertSame([
            'm1' => [
                '1 Message A',
                '1 Message B',
            ],
            'm2' => [
                '2 Message A',
            ],
            'm3' => [
                '3 Message A',
            ]
        ], $this->messages->getAll());
    }

    public function testClear(): void
    {
        $this->messages->clear('m1');

        $this->assertSame([], $this->messages->get('m1'));
    }

    public function testClearAll(): void
    {
        $this->messages->clearAll();

        $this->assertSame([], $this->messages->getAll());
    }

    public function testCount(): void
    {
        $this->assertSame(1, $this->messages->count('m1'));
        $this->assertSame(0, $this->messages->count('m9'));
    }


    public function testCreateByReference(): void
    {
        $GLOBALS = [
            'm1' => [
                '1 Message A'
            ]
        ];

        $message = Messages::createByReference($GLOBALS);

        $message->add('m1', '2 Message B');

        $this->assertSame($GLOBALS, $message->getAll());
    }

    public function testGet(): void
    {
        $this->assertSame([
            '1 Message A'
        ], $this->messages->get('m1'));

        $this->assertSame([], $this->messages->get('m9'));
    }

    public function testGetFirst(): void
    {
        $this->messages->add('m1', '1 Message B');

        $this->assertSame('1 Message A', $this->messages->getFirst('m1'));
        $this->assertSame([], $this->messages->getFirst('m9'));
    }

    public function testGetLast(): void
    {
        $this->messages->add('m1', '1 Message B');

        $this->assertSame('1 Message B', $this->messages->getLast('m1'));
        $this->assertSame([], $this->messages->getLast('m9'));
    }

    public function testGetall(): void
    {
        $this->assertSame([
            'm1' => [
                '1 Message A',
            ],
            'm2' => []
        ], $this->messages->getAll());
    }

    public function testHas(): void
    {
        $this->assertTrue($this->messages->has('m1'));
        $this->assertFalse($this->messages->has('m9'));
    }
}
