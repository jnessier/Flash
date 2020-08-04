<?php


namespace Neoflow\FlashMessages;

interface MessagesInterface
{
    /**
     * Add message by key.
     *
     * @param string $key Key as identifier
     * @param mixed $message Message
     * @return self
     */
    public function add(string $key, $message): self;

    /**
     * Clear messages by key.
     *
     * @param string $key Key as identifier
     * @return void
     */
    public function clear(string $key): void;

    /**
     * Clear all messages.
     *
     * @return void
     */
    public function clearAll(): void;

    /**
     * Count number of messages by key.
     *
     * @param string $key Key as identifier
     * @return int
     */
    public function count(string $key): int;

    /**
     * Create handler with messages.
     *
     * @param array $messages Messages
     * @return Messages
     */
    public static function create(array $messages): self;

    /**
     * Create handler with referenced messages.
     *
     * @param array $messages Messages
     * @return Messages
     */
    public static function createByReference(array &$messages): self;

    /**
     * Get messages by key
     *
     * @param string $key Key as identifier
     * @param mixed $default Fallback value when key doesn't exists
     * @return array
     */
    public function get(string $key, array $default = []): array;

    /**
     * Get all messages.
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Get first message by key.
     *
     * @param string $key Key as identifier
     * @param mixed $default Fallback value when key doesn't exists
     *
     * @return mixed
     */
    public function getFirst(string $key, $default = null);

    /**
     * Get last message by key
     *
     * @param string $key Key as identifier
     * @param mixed $default Default value when key doesn't exists
     *
     * @return mixed
     */
    public function getLast(string $key, $default = null);

    /**
     * Check whether messages by key exists.
     *
     * @param string $key Key as identifier
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Set messages. Already set messages will be overwritten.
     *
     * @param array $messages Messages
     *
     * @return MessagesInterface
     */
    public function set(array $messages): MessagesInterface;

    /**
     * Set referenced messages. Already set messages will be overwritten.
     *
     * @param array $messages Messages
     *
     * @return MessagesInterface
     */
    public function setReference(array &$messages): MessagesInterface;
}
