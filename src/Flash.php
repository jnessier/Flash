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
     * @param array|ArrayAccess|null $storage Flash messages storage
     *
     * @throws FlashException
     */
    public function __construct(string $key = '_flashMessages', &$storage = null)
    {
        $this->key = $key;

        if (!is_null($storage)) {
            $this->loadMessages($storage);
        }
    }

    /**
     * {@inheritDoc}
     *
     * @throws FlashException
     */
    public function addMessage(string $key, $message): FlashInterface
    {
        $this->getNextMessages()->add($key, $message);

        return $this;
    }

    /**
     * {@inheritDoc}
     *
     * @throws FlashException
     */
    public function getCurrentMessages(): MessagesInterface
    {
        if (!$this->currentMessages instanceof Messages) {
            throw new FlashException('Messages for current request does not exists. Messages not loaded from storage yet.');
        }
        return $this->currentMessages;
    }

    /**
     * {@inheritDoc}
     *
     * @throws FlashException
     */
    public function getFirstMessage(string $key, $default = null)
    {
        return $this->getCurrentMessages()->getFirst($key, $default);
    }

    /**
     * {@inheritDoc}
     *
     * @throws FlashException
     */
    public function getLastMessage(string $key, $default = null)
    {
        return $this->getCurrentMessages()->getLast($key, $default);
    }

    /**
     * {@inheritDoc}
     *
     * @throws FlashException
     */
    public function getMessages(string $key, array $default = []): array
    {
        return $this->getCurrentMessages()->get($key, $default);
    }

    /**
     * {@inheritDoc}
     *
     * @throws FlashException
     */
    public function getNextMessages(): MessagesInterface
    {
        if (!$this->nextMessages instanceof Messages) {
            throw new FlashException('Messages for next request does not exists. Messages not loaded from storage yet.');
        }
        return $this->nextMessages;
    }

    /**
     * {@inheritDoc}
     */
    public function keepMessages(): void
    {
        $currentMessages = $this->currentMessages->getAll();
        $this->nextMessages->set($currentMessages);
    }

    /**
     * {@inheritDoc}
     *
     * @throws FlashException
     */
    public function loadMessages(&$storage): FlashInterface
    {
        if (!is_array($storage) && !$storage instanceof ArrayAccess) {
            throw new FlashException('Load messages from storage failed. Storage must be an array or an ArrayAccess-implementation.');
        }

        $this->currentMessages = Messages::create([]);
        $storage = (array) $storage;
        if (array_key_exists($this->key, $storage)) {
            if (!is_array($storage[$this->key])) {
                throw new FlashException('Load messages from storage failed. Key "' . $this->key . '" for flash messages found, but value is not an array.');
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
            throw new FlashException('Load messages from session failed. Session not started yet.');
        }
        return $this->loadMessages($_SESSION);
    }
}
