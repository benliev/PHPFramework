<?php

namespace Framework;

/**
 * Class Module
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework
 */
abstract class Module
{
    /**
     * Path to definitions file
     * @return string|null
     */
    public abstract static function getDefinitions(): ?string;

    /**
     * Path to seeds directory
     * @return string|null
     */
    public abstract static function getSeeds(): ?string;

    /**
     * Path to migrations directory
     * @return string|null
     */
    public abstract static function getMigrations(): ?string;
}
