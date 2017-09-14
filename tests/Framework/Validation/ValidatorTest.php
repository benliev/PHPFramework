<?php

namespace Tests\Framework\Validation;

use Framework\Validation\Validator;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatorTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package Tests\Framework
 */
class ValidatorTest extends TestCase
{

    private function makeValidator(array $params) : Validator
    {
        return new Validator($params);
    }

    public function testRequiredIfFail()
    {
        $errors = $this->makeValidator(['name' => 'joe'])
            ->required('name', 'content')
            ->getErrors();

        $this->assertCount(1, $errors);
    }

    public function testRequiredIfSuccess()
    {
        $errors = $this->makeValidator(['name' => 'joe', 'content' => 't'])
            ->required('name', 'content')
            ->getErrors();

        $this->assertCount(0, $errors);
    }

    public function testSlugSuccess()
    {
        $errors = $this->makeValidator(['slug' => 'aze-aze', 'slug2' => 'aze'])
            ->slug('slug')
            ->slug('slug2')
            ->getErrors();

        $this->assertCount(0, $errors);
    }

    public function testSlugError()
    {
        $errors = $this->makeValidator([
            'slug' => 'aze-azeAze16',
            'slug2' => 'aze-aze_aze16',
            'slug3' => 'aze--aze_aze',
            'slug4' => 'aze-aze-aze-'
        ])
            ->slug('slug')
            ->slug('slug2')
            ->slug('slug3')
            ->slug('slug4')
            ->getErrors();

        $this->assertCount(4, $errors);
    }
    
    public function testNotEmpty()
    {
        $errors = $this->makeValidator([
            'name' => 'toto',
            'content' => '',
        ])
            ->notEmpty('content')
            ->getErrors();
        $this->assertCount(1, $errors);
    }

    public function testLength()
    {
        $params = ['content' => '123456789'];

        $errors = $this->makeValidator($params)
            ->length('content', 3)
            ->getErrors();
        $this->assertCount(0, $errors);

        $errors = $this->makeValidator($params)
            ->length('content', 12)
            ->getErrors();
        $this->assertCount(1, $errors);

        $errors = $this->makeValidator($params)
            ->length('content', 3, 4)
            ->getErrors();
        $this->assertCount(1, $errors);

        $errors = $this->makeValidator($params)
            ->length('content', 3, 20)
            ->getErrors();
        $this->assertCount(0, $errors);

        $errors = $this->makeValidator($params)
            ->length('content', null, 8)
            ->getErrors();
        $this->assertCount(1, $errors);
    }

    public function testDateTime()
    {
        $errors = $this->makeValidator(['date' => '2012-12-12 11:12:13'])
            ->dateTime('date')
            ->getErrors();
        $this->assertCount(0, $errors);

        $errors = $this->makeValidator(['date' => '2012-12-12 11:12:13'])
            ->dateTime('date')
            ->getErrors();
        $this->assertCount(0, $errors);

        $errors = $this->makeValidator(['date' => '2012-21-12 11:12:13'])
            ->dateTime('date')
            ->getErrors();
        $this->assertCount(1, $errors);

        $errors = $this->makeValidator(['date' => '2013-02-29 11:12:13'])
            ->dateTime('date')
            ->getErrors();
        $this->assertCount(1, $errors);
    }
}
