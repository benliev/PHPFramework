<?php


namespace Framework\Routing;

/**
 * Represent route matching
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework
 */
class Route
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var callable|string
     */
    private $callback;

    /**
     * @var string[]
     */
    private $params;

    /**
     * Route constructor.
     * @param string $name
     * @param callable|string $callback
     * @param array $params
     */
    public function __construct(string $name, $callback, array $params = [])
    {

        $this->name = $name;
        $this->callback = $callback;
        $this->params = $params;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return callable|string
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * Retrieve the URL parameters
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
