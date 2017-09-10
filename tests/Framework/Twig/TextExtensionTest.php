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

    public function testExcerptWithShortText()
    {
        $text = "Salut";
        $this->assertEquals($text, (new TextExtension())->excerpt($text), 10);
    }

    public function testExcerptWithLongText()
    {
        $text = "Salut les gens du monde";
        $this->assertEquals('Salut les gens...', (new TextExtension())->excerpt($text, 16));
    }
}
