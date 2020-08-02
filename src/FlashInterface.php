<?php


namespace Neoflow\FlashMessages;

use ArrayAccess;
use ArrayObject;

interface FlashInterface
{
    /**
     * Add message by key for next request
     *
     * @param string $key Key as identifier
     * @param mixed $message Message to add
     * @return self
     */
    public function addMessage(string $key, $message): self;

    /**
     * Get messages set for current request
     *
     * @return MessagesInterface
     */
    public function getCurrentMessages(): MessagesInterface;

    /**
     * Get first message by key from current request
     *
     * @param string $key Key as identifier
     * @param mixed $default Fallback value when key doesn't exists
     * @return mixed
     */
    public function getFirstMessage(string $key, $default = null);

    /**
     * Get last message by key from current request
     *
     * @param string $key Key as identifier
     * @param mixed $default Fallback value when key doesn't exists
     * @return mixed
     */
    public function getLastMessage(string $key, $default = null);

    /**
     * Get messages by key from current request
     *
     * @param string $key Key as identifier
     * @param mixed $default Fallback value when key doesn't exists
     * @return array
     */
    public function getMessages(string $key, array $default = []): array;

    /**
     * Get messages set for next request
     *
     * @return MessagesInterface
     */
    public function getNextMessages(): MessagesInterface;

    /**
     * Keep current messages for next request
     *
     * @return self
     */
    public function keepMessages(): self;

    /**
     * Load storage of flash messages
     *
     * @param array|ArrayAccess|ArrayObject $storage Flash messages storage
     * @return self
     */
    public function loadMessages(&$storage): self;

    /**
     * Load storage of flash messages from session
     *
     * @return self
     */
    public function loadMessagesFromSession(): self;
}
