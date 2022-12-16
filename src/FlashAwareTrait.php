<?php

namespace Neoflow\Flash;

trait FlashAwareTrait
{
    /**
     * @var FlashInterface
     */
    protected $flash;

    /**
     * Set flash service
     *
     * @param FlashInterface $flash
     *
     * @return void
     */
    public function setFlash(FlashInterface $flash): void
    {
        $this->flash = $flash;
    }
}
