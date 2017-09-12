<?php

namespace Framework\Session;

/**
 * Class FlashService
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Session
 */
class FlashService
{

    /**
     * Key session for flash messages
     */
    private const SESSION_KEY = 'flash';

    /**
     * @var array
     */
    private $messages;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * FlashService constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Add message in flash session
     * @param string $type
     * @param string $message
     */
    private function addMessage(string $type, string $message)
    {
        $flash = $this->session->get(self::SESSION_KEY, []);
        $flash[$type] = $message;
        $this->session->set(self::SESSION_KEY, $flash);
    }

    /**
     * Add error flash message
     * @param string $message
     */
    public function error(string $message)
    {
        $this->addMessage('error', $message);
    }

    /**
     * Add success flash message
     * @param string $message
     */
    public function success(string $message)
    {
        $this->addMessage('success', $message);
    }

    /**
     * Get message from the flash type
     * @param string $type
     * @return null|string
     */
    public function get(string $type): ?string
    {
        if (is_null($this->messages)) {
            $this->messages = $this->session->get(self::SESSION_KEY, []);
            $this->session->delete(self::SESSION_KEY);
        }
        return $this->messages[$type] ?? null;
    }
}
