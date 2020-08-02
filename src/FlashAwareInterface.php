<?php


namespace Neoflow\FlashMessages;

interface FlashAwareInterface
{

    /**
     * Set flash messages service
     *
     * @param FlashInterface $flash
     * @return void
     */
    public function setFlash(FlashInterface $flash): void;
}
