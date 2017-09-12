<?php

namespace Framework\Database;

use PDO;
use Psr\Container\ContainerInterface;

/**
 * Class PDOFactory
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Framework\Database
 */
class PDOFactory
{
    /**
     * @param ContainerInterface $container
     * @return PDO
     */
    public function __invoke(ContainerInterface $container)
    {
        $pdo = new PDO(
            'mysql:host='.$container->get('database.host').';dbname='.$container->get('database.name'),
            $container->get('database.username'),
            $container->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
        return $pdo;
    }
}
