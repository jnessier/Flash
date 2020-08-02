<?php


namespace Neoflow\FlashMessages;

use ArrayAccess;
use ArrayObject;
use InvalidArgumentException;
use Neoflow\FlashMessages\Exception\FlashException;
use RuntimeException;

final class Flash implements FlashInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var Messages
     */
    private $currentMessages;

    /**
     * @var Messages
     */
    private $nextMessages;

    /**
     * Constructor.
     *
     * @param string $key Key as messages identifier
     * @param array|ArrayAccess|ArrayObject|null $storage Flash messages storage
     */
    public function __construct(string $key = '_flashMessages', &$storage = null)
    {
        $this->key = $key;

        if (!is_null($storage)) {
            $storage = $storage;
            $this->loadMessages($storage);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function addMessage(string $key, $message): FlashInterface
    {
        $this->nextMessages->add($key, $message);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentMessages(): MessagesInterface
    {
        return $this->currentMessages;
    }

    /**
     * {@inheritDoc}
     */
    public function getFirstMessage(string $key, $default = null)
    {
        return $this->currentMessages->getFirst($key, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function getLastMessage(string $key, $default = null)
    {
        return $this->currentMessages->getLast($key, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function getMessages(string $key, array $default = []): array
    {
        return $this->currentMessages->get($key, $default);
    }

    /**
     * {@inheritDoc}
     */
    public function getNextMessages(): MessagesInterface
    {
        return $this->nextMessages;
    }

    /**
     * {@inheritDoc}
     */
    public function keepMessages(): FlashInterface
    {
        $currentMessages = $this->currentMessages->getAll();
        $this->nextMessages->set($currentMessages);

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @throws FlashException
     */
    public function loadMessages(&$storage): FlashInterface
    {
        if (!is_array($storage) && !$storage instanceof ArrayAccess && !$storage instanceof ArrayObject) {
            throw new FlashException('Loading storage failed. Storage must be an array or an ArrayAccess (or ArrayObject) implementation.');
        }

        $this->currentMessages = Messages::create([]);
        $storage = (array) $storage;
        if (array_key_exists($this->key, $storage)) {
            if (!is_array($storage[$this->key])) {
                throw new FlashException('Loading storage failed. Key "' . $this->key . '" for flash messages found, but value is not an array.');
            }
            $this->currentMessages->set($storage[$this->key]);
        }

        $storage[$this->key] = [];

        $this->nextMessages = Messages::createByReference($storage[$this->key]);

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @throws FlashException
     */
    public function loadMessagesFromSession(): FlashInterface
    {
        if (!isset($_SESSION)) {
            throw new FlashException('Loading storage from session failed. Session not started yet.');
        }
        return $this->loadMessages($_SESSION);
    }
}
