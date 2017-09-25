<?php

namespace Test\Framework\Twig;

use Framework\Twig\BootstrapFormExtension;
use PHPUnit\Framework\TestCase;

/**
 * Class FormExtensionTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Test\Framework\Twig
 */
class BootstrapFormExtensionTest extends TestCase
{
    /** @var BootstrapFormExtension */
    private $formExtension;

    public function setUp()
    {
        $this->formExtension = new BootstrapFormExtension();
    }

    public function testField()
    {
        $html = $this->formExtension->field(
            [],
            'name',
            'demo',
            'Titre'
        );
        $this->assertXmlStringEqualsXmlString("
            <div class='form-group'>
                <label for='name'>Titre</label>
                <input type='text' class='form-control' name='name' id='name' value='demo' />
            </div>", $html);
    }

    public function testFieldWithClass()
    {
        $html = $this->formExtension->field(
            [],
            'name',
            'demo',
            'Titre',
            ['class' => 'datepicker']
        );
        $this->assertXmlStringEqualsXmlString("
            <div class='form-group'>
                <label for='name'>Titre</label>
                <input type='text' class='form-control datepicker' name='name' id='name' value='demo' />
            </div>", $html);
    }

    public function testTextarea()
    {
        $html = $this->formExtension->field(
            [],
            'name',
            'demo',
            'Titre',
            ['type' => 'textarea']
        );
        $this->assertXmlStringEqualsXmlString("
            <div class='form-group'>
                <label for='name'>Titre</label>
                <textarea class='form-control' name='name' id='name'>demo</textarea>
            </div>", $html);
    }

    public function testFieldWithErrors()
    {
        $context = ['errors' => ['name' => 'erreur']];
        $html = $this->formExtension->field($context, 'name', 'demo', 'Titre');
        $this->assertXmlStringEqualsXmlString("
            <div class='form-group has-danger'>
                <label for='name'>Titre</label>
                <input type='text' class='form-control form-control-danger' name='name' id='name' value='demo'/>
                <small class='form-text text-muted'>erreur</small>
            </div>", $html);
    }
}
