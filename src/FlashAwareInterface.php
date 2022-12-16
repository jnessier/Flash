<?php


namespace Neoflow\Flash;

interface FlashAwareInterface
{
    /**
     * Set flash service
     *
     * @param FlashInterface $flash
     *
     * @return void
     */
    public function setFlash(FlashInterface $flash): void;
}
