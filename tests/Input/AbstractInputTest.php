<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Input;

use PHPUnit_Framework_TestCase as TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Slick\Form\Element\Label;
use Slick\Form\Input\AbstractInput;
use Slick\Form\Utils\AttributesMapInterface;

/**
 * Abstract Input test case
 *
 * @package Slick\Tests\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class AbstractInputTest extends TestCase
{

    /**
     * @var AbstractInput|MockObject
     */
    protected $input;

    /**
     * Sets the SUT input object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->input = $this->getMockBuilder(AbstractInput::class)
            ->setMethods(['getAttribute', 'setAttribute', 'getAttributes'])
            ->getMockForAbstractClass();
    }

    /**
     * Clears SUT for next test
     */
    protected function tearDown()
    {
        $this->input = null;
        parent::tearDown();
    }

    /**
     * Should set the attribute name on the attribute collections
     * @test
     */
    public function setNameAttribute()
    {
        $name = 'test';
        $this->input->expects($this->once())
            ->method('setAttribute')
            ->with('name', $name);
        $this->input->expects($this->once())
            ->method('getAttribute')
            ->with('name')
            ->willReturn($name);
        $this->assertSame($this->input, $this->input->setName($name));
        $this->assertEquals($name, $this->input->getName());
    }

    /**
     * Should set the input id to the for attribute of the provided label
     * @test
     */
    public function setLabelElement()
    {
        $label = new Label('test', 'test');
        $name = 'address';
        $this->input->expects($this->once())
            ->method('getAttribute')
            ->with('name')
            ->willReturn($name);
        $this->assertSame($this->input, $this->input->setLabel($label));
        $this->assertEquals(
            'input-address',
            $this->input->getLabel()->getAttribute('for')
        );
    }

    /**
     * Should create the label element with provided string as value
     * @test
     */
    public function setLabelWithString()
    {
        $name = 'address';
        $string = "Home address";
        $this->input->expects($this->once())
            ->method('getAttribute')
            ->with('name')
            ->willReturn($name);
        $this->input->setLabel($string);
        $label = $this->input->getLabel();
        $this->assertEquals($string, $label->getValue());
        $this->assertEquals(
            'input-address',
            $this->input->getLabel()->getAttribute('for')
        );
    }

    /**
     * Should instantiate the provided class, set the value based on input
     * name and set the for attribute.
     * @test
     */
    public function createLabelWithClassName()
    {
        $name = 'address';
        $string = "Slick\\Form\\Element\\Label";
        $this->input->expects($this->atMost(2))
            ->method('getAttribute')
            ->with('name')
            ->willReturn($name);
        $this->input->setLabel($string);
        $label = $this->input->getLabel();
        $this->assertEquals('Address', $label->getValue());
        $this->assertEquals(
            'input-address',
            $this->input->getLabel()->getAttribute('for')
        );
    }

    /**
     * @test
     * @expectedException \Slick\Form\Exception\InvalidArgumentException
     */
    public function createLabelWithInvalidString()
    {
        $this->input->setLabel(1123.34);
    }

    /**
     * @test
     * @expectedException \Slick\Form\Exception\InvalidArgumentException
     */
    public function createLabelWithInvalidClass()
    {
        $this->input->setLabel('stdClass');
    }

    /**
     * @test
     * @expectedException \Slick\Form\Exception\InvalidArgumentException
     */
    public function createLabelWithInvalidObject()
    {
        $this->input->setLabel(new \stdClass());
    }

    /**
     * Should return the raw value
     * @test
     */
    public function getRawValue()
    {
        $this->input->setValue('test');
        $this->assertEquals('test', $this->input->getRawValue());
    }

    /**
     * Should remove the attribute if required is false
     * @test
     */
    public function setRequired()
    {
        $map = $this->getAttributesMapMocked();
        $map->expects($this->once())
            ->method('containsKey')
            ->with('required')
            ->willReturn(true);
        $map->expects($this->once())
            ->method('remove')
            ->with('required');
        $this->input->expects($this->atLeastOnce())
            ->method('getAttributes')
            ->willReturn($map);
        $this->input->setRequired(false);

    }

    /**
     * Gets a mocked attributes map
     *
     * @return MockObject|AttributesMapInterface
     */
    protected function getAttributesMapMocked()
    {
        $class = AttributesMapInterface::class;
        $methods = get_class_methods($class);
        /** @var MockObject|AttributesMapInterface $map */
        $map = $this->getMockBuilder($class)
            ->setMethods($methods)
            ->getMock();
        return $map;
    }
}
