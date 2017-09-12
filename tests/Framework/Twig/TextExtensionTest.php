<?php

namespace Test\Framework\Twig;

use Framework\Twig\TextExtension;
use PHPUnit\Framework\TestCase;

/**
 * Class TextExtensionTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Test\Framework\Twig
 */
class TextExtensionTest extends TestCase
{

    /**
     * @var TextExtension
     */
    private $textExtension;

    public function setUp()
    {
        $this->textExtension = new TextExtension();
    }

    public function testExcerptWithShortText()
    {
        $text = "Salut";
        $this->assertEquals($text, $this->textExtension->excerpt($text), 10);
    }

    public function testExcerptWithLongText()
    {
        $text = "Salut les gens du monde";
        $this->assertEquals('Salut les gens...', $this->textExtension->excerpt($text, 16));
    }
}
