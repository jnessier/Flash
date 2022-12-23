<?php


namespace Neoflow\Flash;

interface FlashInterface
{
    /**
     * Clear values of current and next request.
     *
     * @return self
     */
    public function clear(): FlashInterface;

    /**
     * Count number of values set for current request.
     *
     * @return int
     */
    public function count(): int;

    /**
     * Get values for current request.
     *
     * @return array
     */
    public function getCurrent(): array;

    /**
     * Get value by key set for current request.
     *
     * @param string $key Key as identifier of the value
     * @param mixed $default Default value, when key does not exist
     *
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Get values set for next request.
     *
     * @return array
     */
    public function getNext(): array;

    /**
     * Check whether value by key for current request exists.
     *
     * @param string $key Key as identifier of the value
     *
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Set value by key for next request. Existing value will be overwritten.
     *
     * @param string $key Key as identifier of the value
     * @param mixed $value Value to set
     *
     * @return self
     */
    public function set(string $key, $value): FlashInterface;

    /**
     * Remove value by key for next request.
     *
     * @param string $key Key as identifier of the value
     *
     * @return FlashInterface
     */
    public function remove(string $key): FlashInterface;

    /**
     * Keep current values for next request. Existing values will be overwritten.
     *
     * @return self
     */
    public function keep(): FlashInterface;

    /**
     * Load values from storage as reference.
     *
     * @param array $storage Storage to load the values from
     *
     * @return self
     */
    public function load(array &$storage): FlashInterface;

    /**
     * Set values for current request. Existing values will be overwritten.
     *
     * @param array $values Values to set
     *
     * @return FlashInterface
     */
    public function setCurrent(array $values): FlashInterface;

    /**
     * Set values next request. Existing values will be overwritten.
     *
     * @param array $values Values to set
     *
     * @return FlashInterface
     */
    public function setNext(array $values): FlashInterface;
}
