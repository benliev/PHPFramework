<?php

namespace Tests\Framework\Session;

use Framework\Session\ArraySession;
use Framework\Session\FlashService;
use Framework\Session\SessionInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class FlashServiceTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Tests\Framework\Session
 */
class FlashServiceTest extends TestCase
{

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var FlashService
     */
    private $flash;

    public function setUp()
    {
        $this->session = new ArraySession();
        $this->flash = new FlashService($this->session);
    }

    public function testDeleteFlashAfterGettingIt()
    {
        $this->flash->success('Bravo');
        $this->assertEquals('Bravo', $this->flash->get('success'));
        $this->assertNull($this->session->get('flash'));
        $this->assertEquals('Bravo', $this->flash->get('success'));
    }
}
