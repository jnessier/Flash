<?php


namespace Neoflow\Flash\Test;

use Neoflow\Flash\Flash;
use Neoflow\Flash\FlashAwareInterface;
use Neoflow\Flash\FlashAwareTrait;
use PHPUnit\Framework\TestCase;

class FlashAwareTraitTest extends TestCase implements FlashAwareInterface
{
    use FlashAwareTrait;

    public function test(): void
    {
        $flash = new Flash();
        $this->setFlash($flash);

        $this->assertSame($flash, $this->flash);
    }
}
