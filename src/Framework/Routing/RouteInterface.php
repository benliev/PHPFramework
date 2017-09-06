<?php


namespace Framework\Routing;

interface RouteInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return callable
     */
    public function getCallback(): callable;
    /**
     * Retrieve the URL parameters
     * @return string[]
     */
    public function getParams(): array;
}
