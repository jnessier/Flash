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
    private $current;

    /**
     * @var array
     */
    private $next;

    /**
     * Constructor.
     *
     * @param string $key Key as identifier of the message groups in the storage
     * @param array|null $storage Storage to load the message groups from
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
    public function addMessage(string $key, $message): FlashInterface
    {
        if (!isset($this->next[$key])) {
            $this->next[$key] = [];
        }

        $this->next[$key] = $message;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clear(): FlashInterface
    {
        $this->current = [];
        $this->next = [];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function countMessages(string $key): int
    {
        if ($this->hasMessages($key)) {
            return count($this->current);
        }

        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrent(): array
    {
        return $this->current;
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrent(array $groups): FlashInterface
    {
        $this->current = $groups;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getFirstMessage(string $key, $default = null)
    {
        if ($this->countMessages($key) > 0) {
            return $this->current[$key][0];
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastMessage(string $key, $default = null)
    {
        $numberOfMessages = $this->countMessages($key);
        if ($numberOfMessages > 0) {
            $lastIndex = $numberOfMessages - 1;
            return $this->current[$key][$lastIndex];
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(string $key, $default = []): array
    {
        if ($this->hasMessages($key)) {
            return $this->current[$key];
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getNext(): array
    {
        return $this->next;
    }

    /**
     * {@inheritDoc}
     */
    public function setNext(array $groups): FlashInterface
    {
        $this->next = $groups;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function hasMessages(string $key): bool
    {
        return isset($this->current[$key]);
    }

    /**
     * {@inheritDoc}
     */
    public function keep(): FlashInterface
    {
        $this->next = $this->current;

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
            $this->current = $storage[$this->key];
        }

        $storage[$this->key] = [];

        $this->next = &$storage[$this->key];

        return $this;
    }

}
