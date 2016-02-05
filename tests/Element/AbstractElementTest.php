<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Element;

use PHPUnit_Framework_TestCase as TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Slick\Form\Element\AbstractElement;
use Slick\Form\Utils\AttributesMapInterface;

/**
 * Abstract Element test case
 *
 * @package Slick\Tests\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class AbstractElementTest extends TestCase
{

    /**
     * @var AbstractElement|MockObject
     */
    protected $element;

    /**
     * Sets the SUT object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->element = $this->getMockForAbstractClass(
            AbstractElement::class
        );
    }

    /**
     * Clear SUT for next test
     */
    protected function tearDown()
    {
        $this->element = null;
        parent::tearDown();
    }

    /**
     * Should set the element value and return self instance
     * @test
     */
    public function setValue()
    {
        $this->assertSame($this->element, $this->element->setValue('test'));
        $this->assertEquals('test', $this->element->getValue());
    }

    /**
     * Should call the AttributesMap::set() method
     * @test
     */
    public function setAttribute()
    {
        $name = 'class';
        $value = 'test';
        $attributes = $this->getAttributesMapMock();
        $attributes->expects($this->once())
            ->method('set')
            ->with($name, $value)
            ->willReturn($attributes);
        $this->element->setAttributes($attributes);
        $this->assertSame(
            $this->element,
            $this->element->setAttribute($name, $value)
        );
    }

    /**
     * Should call the AttributesMap::get() method and return the value
     * @test
     */
    public function getExistingAttribute()
    {
        $name = 'class';
        $value = 'test';
        $attributes = $this->getAttributesMapMock();
        $attributes->expects($this->once())
            ->method('containsKey')
            ->with($name)
            ->willReturn(true);
        $attributes->expects($this->once())
            ->method('get')
            ->with($name)
            ->willReturn($value);
        $this->element->setAttributes($attributes);
        $this->assertEquals($value, $this->element->getAttribute($name));
    }

    /**
     * Should not call the AttributesMap::get() method and return
     * the default value
     * @test
     */
    public function getUnknownAttribute()
    {
        $name = 'class';
        $default = false;
        $attributes = $this->getAttributesMapMock();
        $attributes->expects($this->once())
            ->method('containsKey')
            ->with($name)
            ->willReturn(false);
        $attributes->expects($this->never())
            ->method('get');
        $this->element->setAttributes($attributes);
        $this->assertFalse($this->element->getAttribute($name, $default));
    }

    /**
     * Lazy create of empty attributes collection
     * @test
     */
    public function createAttributesMap()
    {
        $attributes = $this->element->getAttributes();
        $this->assertInstanceOf(AttributesMapInterface::class, $attributes);
    }

    /**
     * Should set and retrieve name without adding it to the attributes
     * @test
     */
    public function setElementName()
    {
        $name = 'test';
        $this->assertSame($this->element, $this->element->setName($name));
        $attributes = $this->element->getAttributes();
        $this->assertFalse($attributes->containsKey('name'));
        $this->assertEquals($name, $this->element->getName());
    }

    /**
     * Gets a mocked attributes map object
     *
     * @return MockObject|AttributesMapInterface
     */
    protected function getAttributesMapMock()
    {
        $class = AttributesMapInterface::class;
        $methods = get_class_methods($class);
        /** @var AttributesMapInterface|MockObject $attributes */
        $attributes = $this->getMockBuilder($class)
            ->setMethods($methods)
            ->getMock();
        return $attributes;
    }
}
