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
     * Get messages, set for the current request
     *
     * @return MessagesInterface
     */
    public function getCurrentMessages(): MessagesInterface;

    /**
     * Get first message by key, set for the current request
     *
     * @param string $key Key as identifier
     * @param mixed $default Fallback value when no message exists
     * @return mixed
     */
    public function getFirstMessage(string $key, $default = null);

    /**
     * Get last message by key, set for the current request
     *
     * @param string $key Key as identifier
     * @param mixed $default Fallback value when no message exists
     * @return mixed
     */
    public function getLastMessage(string $key, $default = null);

    /**
     * Get messages by key, set for the current request
     *
     * @param string $key Key as identifier
     * @param mixed $default Fallback value when no messages exists
     * @return array
     */
    public function getMessages(string $key, array $default = []): array;

    /**
     * Get messages, set for the next request
     *
     * @return MessagesInterface
     */
    public function getNextMessages(): MessagesInterface;

    /**
     * Keep current messages for the next request
     *
     * @return self
     */
    public function keepMessages(): self;

    /**
     * Load messages from storage
     *
     * @param array|ArrayAccess|ArrayObject $storage Flash messages storage
     * @return self
     */
    public function loadMessages(&$storage): self;

    /**
     * Load messages from session
     *
     * @return self
     */
    public function loadMessagesFromSession(): self;
}
