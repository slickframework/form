<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form;

use PHPUnit_Framework_TestCase as TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Slick\Form\Element\Button;
use Slick\Form\Element\FieldSet;
use Slick\Form\Form;
use Slick\Form\Input\Text;

/**
 * HTML Form test case
 *
 * @package Slick\Tests\Form
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class FormTest extends TestCase
{

    /**
     * @var Form|MockObject
     */
    protected $form;

    /**
     * Sets the SUT form object
     */
    protected function setUp()
    {
        parent::setUp();
        $class = Form::class;
        $this->form = $this->getMockBuilder($class)
            ->setMethods(['setValues'])
            ->getMock();
    }

    /**
     * Should create a form with action and method attributes defined
     * @test
     */
    public function defaultAttributes()
    {
        $this->assertEquals('', $this->form->getAttribute('action'));
        $this->assertEquals('post', $this->form->getAttribute('method'));
    }

    /**
     * Should call FieldSet::setValues() to populate all data
     * @test
     */
    public function setData()
    {
        $data = ['foo' => 'bar'];
        $this->form->expects($this->once())
            ->method('setValues')
            ->with($data)
            ->willReturn($this->form);
        $this->assertSame($this->form, $this->form->setData($data));
    }

    /**
     * Should set the request and return a self instance
     * @test
     */
    public function setRequest()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->getMock(ServerRequestInterface::class);
        $this->assertSame($this->form, $this->form->setRequest($request));
    }

    /**
     * Should recursively get the names of the input elements
     * @test
     */
    public function getData()
    {
        $text = (new Text())->setName('baz')->setValue('bum');
        $group = (new FieldSet())->add($text);
        $this->form
            ->add((new Text())->setName('foo')->setValue('bar'))
            ->add($group)
            ->add(new Button());
        $this->assertEquals(
            ['foo' => 'bar', 'baz' => 'bum'],
            $this->form->getData()
        );
    }
}
