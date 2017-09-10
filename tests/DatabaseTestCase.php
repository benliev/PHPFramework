<?php

namespace Tests;

use PDO;
use Phinx\Config\Config;
use Phinx\Migration\Manager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * Class DatabaseTestCase
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class DatabaseTestCase extends TestCase
{
    /**
     * @var PDO
     */
    protected $pdo;

    public function setUp()
    {
        $this->pdo = new PDO('sqlite::memory:', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_PERSISTENT, true,
        ]);

        $config = require('phinx.php');
        $config['environments']['test'] = [
            'memory' => true,
            'adapter' => 'sqlite',
            'connection' => $this->pdo
        ];

        $manager = new Manager(
            new Config($config),
            new StringInput(''),
            new NullOutput()
        );

        $manager->migrate('test');
        $manager->seed('test');
    }
}
