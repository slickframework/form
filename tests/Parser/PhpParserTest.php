<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Parser;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Form;
use Slick\Form\Parser\PhpParser;

/**
 * Form definitions Php Parser test case
 *
 * @package Slick\Tests\Form\Parser
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class PhpParserTest extends TestCase
{

    /**
     * @var PhpParser
     */
    protected $parser;

    /**
     * Sets the SUT object
     */
    protected function setUp()
    {
        $file = dirname(__DIR__).'/forms/login.php';
        $this->parser = new PhpParser($file);
        parent::setUp();
    }

    /**
     * Should create a form if no form class name is provided
     * @test
     */
    public function getForm()
    {
        $form = $this->parser->getForm();
        $this->assertInstanceOf(Form::class, $form);
    }

    /**
     * Should create a hidden input with form id
     * @test
     */
    public function setFormIdInput()
    {
        $form = $this->parser->getForm();
        $input = $form->get('form-id');
        $this->assertEquals('login-form', $input->getValue());
    }

    /**
     * Should raise an exception
     * @test
     * @expectedException \Slick\Form\Exception\ParserErrorException
     */
    public function parserError()
    {
        $file = dirname(__DIR__).'/forms/error.php';
        PhpParser::create($file);
    }

    /**
     * Should raise an exception
     * @test
     * @expectedException \Slick\Form\Exception\InvalidArgumentException
     */
    public function definitionsFileNotExists()
    {
        PhpParser::create('_test/_not_/found.yml');
    }

    /**
     * Should raise an exception
     * @test
     * @expectedException \Slick\Form\Exception\InvalidArgumentException
     */
    public function formClassDoesNotExists()
    {
        PhpParser::create(['class' => '_unknown_']);
    }

    /**
     * Should raise an exception
     * @test
     * @expectedException \Slick\Form\Exception\InvalidArgumentException
     */
    public function formClassInvalid()
    {
        PhpParser::create(['class' => 'stdClass']);
    }
}
