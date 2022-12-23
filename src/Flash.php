<?php


namespace Neoflow\Flash;

use Neoflow\Flash\Exception\FlashException;

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
     * @param string $key Key as identifier of the values in the storage
     * @param array|null $storage Storage to load the values from
     *
     * @throws FlashException
     */
    public function __construct(string $key = '_flash', array &$storage = null)
    {
        $this->key = $key;

        if (!is_null($storage)) {
            $this->load($storage);
        }
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
    public function count(): int
    {
        return count($this->current);
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
    public function setCurrent(array $values): FlashInterface
    {
        $this->current = $values;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, $default = null)
    {
        if ($this->has($key)) {
            return $this->current[$key];
        }

        return $default;
    }

    /**
     * {@inheritDoc}
     */
    public function set(string $key, $value): FlashInterface
    {
        $this->next[$key] = $value;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function remove(string $key): FlashInterface
    {
        if (isset($this->next[$key])) {
            unset($this->next[$key]);
        }

        return $this;
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
    public function setNext(array $values): FlashInterface
    {
        $this->next = $values;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $key): bool
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
                throw new FlashException(
                    'Load values from storage failed. Key "' . $this->key . '" for values found, but it is not an array.'
                );
            }
            $this->current = $storage[$this->key];
        }

        $storage[$this->key] = [];

        $this->next = &$storage[$this->key];

        return $this;
    }
}
