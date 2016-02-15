<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Form;
use Slick\Form\FormRegistry;

/**
 * Form Registry test case
 *
 * @package Slick\Tests\Form
 * @author  Filipe Silva <silvam.filipe@gmail.com>>
 */
class FormRegistryTest extends TestCase
{

    /**
     * @var FormRegistry
     */
    protected $formRegistry;

    /**
     * Creates the SUT form register interface
     */
    protected function setUp()
    {
        parent::setUp();
        $this->formRegistry = FormRegistry::getInstance();
    }

    /**
     * Creates a form using the login-form.yml
     * @test
     */
    public function createFormYml()
    {
        $file = __DIR__.'/forms/login.yml';
        $form = $this->formRegistry->get($file);
        $this->assertInstanceOf(LoginForm::class, $form);
        $this->assertEquals('login-form', $form->getId());
    }

    /**
     * Uses the static method and create the form using php arrays
     * @test
     */
    public function createFromPhp()
    {
        $file = __DIR__.'/forms/login.php';
        $form = FormRegistry::getForm($file, FormRegistry::PARSER_PHP);
        $this->assertInstanceOf(Form::class, $form);
        $this->assertEquals('login-form', $form->getId());
    }
}
