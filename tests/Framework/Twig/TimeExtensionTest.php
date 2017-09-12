<?php


namespace Test\Framework\Twig;

use Framework\Twig\TimeExtension;
use PHPUnit\Framework\TestCase;

/**
 * Class TextExtensionTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Test\Framework\Twig
 */
class TimeExtensionTest extends TestCase
{

    /**
     * @var TimeExtension
     */
    private $timeExtension;

    public function setUp()
    {
        $this->timeExtension = new TimeExtension();
    }

    public function testAgo()
    {
        $date = new \DateTime();
        $result = '<span class="timeago" datetime="' .
            $date->format(\DateTime::ISO8601). '">'.
            $date->format('d/m/Y H:i') . '</span>';
        $this->assertEquals($result, $this->timeExtension->ago($date));
    }
}
