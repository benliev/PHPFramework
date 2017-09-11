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
    public $pdo;

    /**
     * @var Manager
     */
    private $manager;

    public function setUp()
    {
        $this->pdo = new PDO('sqlite:test.db', null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]);

        $config = require(dirname(__DIR__).'/phinx.php');
        $config['environments']['test'] = [
            'name' => 'test.db',
            'adapter' => 'sqlite',
            'connection' => $this->pdo,
        ];

        $this->manager = new Manager(
            new Config($config),
            new StringInput(' '),
            new NullOutput()
        );
        $this->manager->migrate('test');
    }

    protected function seedDatabase()
    {
        $this->manager->seed('test');
    }
}
