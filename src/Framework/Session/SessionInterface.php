<?php

namespace Framework\Session;

/**
 * Class SessionInterface
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Session
 */
interface SessionInterface
{

    /**
     * return an information in session
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Set an information on session
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function set(string $key, $value) : void;


    /**
     * Delete a key in session
     * @param string $key
     * @return mixed|void
     */
    public function delete(string $key) : void;
}
