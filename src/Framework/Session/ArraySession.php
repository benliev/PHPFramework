<?php

namespace Framework\Session;

/**
 * Class ArraySession
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Session
 */
class ArraySession implements SessionInterface
{

    /**
     * @var array
     */
    private $session;

    /**
     * ArraySession constructor.
     * @param array $session
     */
    public function __construct(array $session = [])
    {
        $this->session = $session;
    }

    /**
     * return an information in session
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->session[$key] ?? $default;
    }

    /**
     * Set an information on session
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function set(string $key, $value) : void
    {
        $this->session[$key] = $value;
    }

    /**
     * Delete a key in session
     * @param string $key
     * @return mixed|void
     */
    public function delete(string $key) : void
    {
        unset($this->session[$key]);
    }
}
