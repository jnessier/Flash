<?php


namespace Neoflow\FlashMessages;

use ArrayAccess;
use Neoflow\FlashMessages\Exception\FlashException;

final class Flash implements FlashInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var array
     */
    private $currentMessages;

    /**
     * @var array
     */
    private $nextMessages;

    /**
     * Constructor.
     *
     * @param string $key Key as identifier of the messages
     * @param array|null $storage Storage to load the messages from
     *
     * @throws FlashException
     */
    public function __construct(string $key = '_flashMessages', array &$storage = null)
    {
        $this->key = $key;

        if (!is_null($storage)) {
            $this->load($storage);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function addMessage($message): FlashInterface
    {
        $this->nextMessages[] = $message;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(): array
    {
        return $this->currentMessages;
    }

    /**
     * {@inheritDoc}
     */
    public function getFirstMessage($default = null)
    {
        if ($this->countMessages() > 0) {
            return $this->currentMessages[0];
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastMessage($default = null)
    {
        $numberOfMessages = $this->countMessages();
        if ($numberOfMessages > 0) {
            $lastIndex = $numberOfMessages - 1;
            return $this->currentMessages[$lastIndex];
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getNextMessages(): array
    {
        return $this->nextMessages;
    }

    /**
     * {@inheritDoc}
     */
    public function keepMessages(): FlashInterface
    {
        $this->nextMessages = $this->currentMessages;

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @throws FlashException
     */
    public function load(array &$storage): FlashInterface
    {
        if (isset($storage[$this->key])) {
            if (!is_array($storage[$this->key])) {
                throw new FlashException('Load messages from storage failed. Key "' . $this->key . '" for flash messages found, but value is not an array.');
            }
            $this->currentMessages = $storage[$this->key];
        }

        $storage[$this->key] = [];

        $this->nextMessages = &$storage[$this->key];

        return $this;
    }


    /**
     * {@inheritDoc}
     */
    public function countMessages(): int
    {
        return count($this->currentMessages);
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrentMessages(array $messages): FlashInterface
    {
        $this->currentMessages = $messages;
    }

    /**
     * {@inheritDoc}
     */
    public function setMessages(array $messages): FlashInterface
    {
        $this->nextMessages = $messages;
    }

    /**
     * {@inheritDoc}
     */
    public function clearMessages(): FlashInterface
    {
        $this->currentMessages = [];
        $this->nextMessages = [];
    }
}
