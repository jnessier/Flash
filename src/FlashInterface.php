<?php


namespace Neoflow\FlashMessages;


interface FlashInterface
{
    /**
     * Add message for next request.
     *
     * @param mixed $message Message to add
     *
     * @return self
     */
    public function addMessage($message): FlashInterface;

    /**
     * Get messages, set for current request.
     *
     * @return array
     */
    public function getMessages(): array;

    /**
     * Count number of messages, set for current request.
     *
     * @return int
     */
    public function countMessages(): int;

    /**
     * Get first message, set for current request.
     *
     * @param mixed $default Default value, when message doesn't exists
     *
     * @return mixed
     */
    public function getFirstMessage($default = null);

    /**
     * Get last message, set for current request.
     *
     * @param mixed $default Default value, when message doesn't exists
     *
     * @return mixed
     */
    public function getLastMessage($default = null);

    /**
     * Get messages, set for next request.
     *
     * @return array
     */
    public function getNextMessages(): array;

    /**
     * Set messages for next request. Existing messages will be overwritten.
     *
     * @param array $messages Messages to set
     *
     * @return FlashInterface
     */
    public function setCurrentMessages(array $messages): FlashInterface;

    /**
     * Set messages for next request. Existing messages will be overwritten.
     *
     * @param array $messages Messages to set
     *
     * @return FlashInterface
     */
    public function setMessages(array $messages): FlashInterface;

    /**
     * Keep current messages for next request. Existing messages will be overwritten.
     *
     * @return self
     */
    public function keepMessages(): FlashInterface;

    /**
     * Clear messages of current and next request.
     *
     * @return self
     */
    public function clearMessages(): FlashInterface;

    /**
     * Load messages from storage.
     *
     * @param array $storage Storage to load the messages from
     *
     * @return self
     */
    public function load(array &$storage): FlashInterface;
}
