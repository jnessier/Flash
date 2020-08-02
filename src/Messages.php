<?php

namespace Neoflow\FlashMessages;

final class Messages implements MessagesInterface
{
    /**
     * @var array
     */
    private $messages;

    /**
     * Constructor.
     *
     * @param array $messages Initial messages
     */
    public function __construct(array &$messages = [])
    {
        $this->messages = &$messages;
    }

    /**
     * {@inheritDoc}
     */
    public function add(string $key, $message): MessagesInterface
    {
        if (!isset($this->messages[$key])) {
            $this->messages[$key] = [];
        }

        $this->messages[$key][] = $message;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clear(string $key): void
    {
        if ($this->hasKey($key)) {
            $this->messages[$key] = [];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function clearAll(): void
    {
        $this->messages = [];
    }

    /**
     * {@inheritDoc}
     */
    public function count(string $key): int
    {
        if ($this->hasKey($key)) {
            return count($this->messages[$key]);
        }

        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function countKeys(): int
    {
        return count($this->messages);
    }

    /**
     * {@inheritDoc}
     */
    public static function create(array $messages): MessagesInterface
    {
        return new static($messages);
    }

    /**
     * {@inheritDoc}
     */
    public static function createByReference(array &$messages): MessagesInterface
    {
        return (new static())->setReference($messages);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteKey(string $key): void
    {
        if ($this->hasKey($key)) {
            unset($this->messages[$key]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, $default = []): array
    {
        if ($this->hasKey($key)) {
            return $this->messages[$key];
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getAll(): array
    {
        return $this->messages;
    }

    /**
     * {@inheritDoc}
     */
    public function getFirst(string $key, $default = [])
    {
        if ($this->hasKey($key) && $this->count($key)) {
            return $this->messages[$key][0];
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function getLast(string $key, $default = [])
    {
        if ($this->hasKey($key) && $this->count($key)) {
            $lastIndex = $this->count($key) - 1;
            return $this->messages[$key][$lastIndex];
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function hasKey(string $key): bool
    {
        return isset($this->messages[$key]);
    }

    /**
     * {@inheritDoc}
     */
    public function set(array $messages): MessagesInterface
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setReference(array &$messages): MessagesInterface
    {
        $this->messages = &$messages;

        return $this;
    }
}
