<?php

namespace Tests\Framework;

use Framework\Renderer\PHPRenderer;
use PHPUnit\Framework\TestCase;

/**
 * Class RendererTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Tests\Framework
 */
class RendererTest extends TestCase
{

    /**
     * @var PHPRenderer
     */
    private $renderer;

    public function setUp()
    {
        $this->renderer = new PHPRenderer();
        $this->renderer->addPath(__DIR__ . '/views', 'blog');
        $this->renderer->addPath(__DIR__ . '/views');
    }

    public function testRenderTheRightPath()
    {
        $content = $this->renderer->render('@blog/demo');
        $this->assertEquals('Hello World !', $content);
    }

    public function testRenderTheDefaultPath()
    {
        $content = $this->renderer->render('demo');
        $this->assertEquals('Hello World !', $content);
    }

    public function testRenderWithParams()
    {
        $name = 'Marc';
        $content = $this->renderer->render('demoparams', compact('name'));
        $this->assertEquals("Salut $name", $content);
    }

    public function testGlobalParameters()
    {
        $name = 'Marc';
        $this->renderer->addGlobal('name', $name);
        $content = $this->renderer->render('demoparams');
        $this->assertEquals("Salut $name", $content);
    }
}
