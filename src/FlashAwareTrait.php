<?php

namespace Neoflow\FlashMessages;

trait FlashAwareTrait
{

    /**
     * @var FlashInterface
     */
    protected $flash;

    /**
     * Set flash messages service
     *
     * @param FlashInterface $flash
     * @return void
     */
    public function setFlash(FlashInterface $flash): void
    {
        $this->flash = $flash;
    }
}
