<?php


namespace Neoflow\FlashMessages\Test;

use Neoflow\FlashMessages\Flash;
use Neoflow\FlashMessages\FlashAwareInterface;
use Neoflow\FlashMessages\FlashAwareTrait;
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
