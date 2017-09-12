<?php

namespace Framework\Session;

/**
 * Class PhpSession
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Session
 */
class PhpSession implements SessionInterface
{

    /**
     * Ensure that session started
     */
    private function ensureStarted()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * return an information in session
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $this->ensureStarted();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Set an information on session
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function set(string $key, $value) : void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * Delete a key in session
     * @param string $key
     * @return mixed|void
     */
    public function delete(string $key) : void
    {
        $this->ensureStarted();
        unset($_SESSION[$key]);
    }
}
