<?php


namespace Neoflow\FlashMessages;

interface MessagesInterface
{
    /**
     * Add message by key
     *
     * @param string $key Key as identifier
     * @param mixed $message Message to add
     * @return self
     */
    public function add(string $key, $message): self;

    /**
     * Clear messages by key
     *
     * @param string $key Key as identifier
     * @return void
     */
    public function clear(string $key): void;

    /**
     * Clear all messages
     *
     * @return void
     */
    public function clearAll(): void;

    /**
     * Count number of messages by key
     *
     * @param string $key Key as identifier
     * @return int
     */
    public function count(string $key): int;

    /**
     * Count number of keys
     *
     * @return int
     */
    public function countKeys(): int;

    /**
     * Create handler
     *
     * @param array $messages Initial messages
     * @return Messages
     */
    public static function create(array $messages): self;

    /**
     * Create handler with referenced messages
     *
     * @param array $messages Initial messages
     * @return Messages
     */
    public static function createByReference(array &$messages): self;

    /**
     * Delete key
     *
     * @param string $key Key as identifier
     */
    public function deleteKey(string $key): void;

    /**
     * Get messages by key
     *
     * @param string $key Key as identifier
     * @param mixed $default Fallback value when key doesn't exists
     * @return array
     */
    public function get(string $key, array $default = []): array;

    /**
     * Get all messages
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Get first message by key
     *
     * @param string $key Key as identifier
     * @param mixed $default Fallback value when key doesn't exists
     * @return mixed
     */
    public function getFirst(string $key, $default = null);

    /**
     * Get last message by key
     *
     * @param string $key Key as identifier
     * @param mixed $default Fallback value when key doesn't exists
     * @return mixed
     */
    public function getLast(string $key, $default = null);

    /**
     * Check whether key exists
     *
     * @param string $key Key as identifier
     * @return bool
     */
    public function hasKey(string $key): bool;

    /**
     * Set messages
     *
     * @param array $messages Messages to set
     * @return MessagesInterface
     */
    public function set(array $messages): MessagesInterface;

    /**
     * Set referenced messages
     *
     * @param array $messages Messages to set
     * @return MessagesInterface
     */
    public function setReference(array &$messages): MessagesInterface;
}
