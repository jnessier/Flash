<?php


namespace Neoflow\FlashMessages;


interface FlashInterface
{
    /**
     * Add message to a message group by key for next request.
     *
     * @param string $key Key as identifier of the message group
     * @param mixed $message Message to add
     *
     * @return self
     */
    public function addMessage(string $key, $message): FlashInterface;

    /**
     * Clear messages of current and next request.
     *
     * @return self
     */
    public function clear(): FlashInterface;

    /**
     * Count number of messages of a message group by key, set for current request.
     *
     * @param string $key Key as identifier of the message group
     *
     * @return int
     */
    public function countMessages(string $key): int;

    /**
     * Get message groups for current request.
     *
     * @return array
     */
    public function getCurrent(): array;

    /**
     * Get first message from a message group by key, set for current request.
     *
     * @param string $key Key as identifier of the message group
     * @param mixed $default Default value, when message group doesn't exists or is empty
     *
     * @return mixed
     */
    public function getFirstMessage(string $key, $default = null);

    /**
     * Get last message from a message group by key, set for current request.
     *
     * @param string $key Key as identifier of the message group
     * @param mixed $default Default value, when message group doesn't exists or is empty
     *
     * @return mixed
     */
    public function getLastMessage(string $key, $default = null);

    /**
     * Get message group by key, set for current request.
     *
     * @param string $key Key as identifier of the message group
     * @param mixed $default Default value, when message group doesn't exists or is empty
     *
     * @return array
     */
    public function getMessages(string $key,  $default = []): array;

    /**
     * Get message groups, set for next request.
     *
     * @return array
     */
    public function getNext(): array;

    /**
     * Check whether message group by key exists.
     *
     * @param string $key Key as identifier of the message group
     *
     * @return bool
     */
    public function hasMessages(string $key): bool;

    /**
     * Keep current message groups for next request. Existing message groups will be overwritten.
     *
     * @return self
     */
    public function keep(): FlashInterface;

    /**
     * Load messages from storage as reference.
     *
     * @param array $storage Storage to load the message groups from
     *
     * @return self
     */
    public function load(array &$storage): FlashInterface;

    /**
     * Set message groups for current request. Existing message groups will be overwritten.
     *
     * @param array $groups Message groups to set
     *
     * @return FlashInterface
     */
    public function setCurrent(array $groups): FlashInterface;

    /**
     * Set message groups for next request. Existing message groups will be overwritten.
     *
     * @param array $groups Message groups to set
     *
     * @return FlashInterface
     */
    public function setNext(array $groups): FlashInterface;
}
