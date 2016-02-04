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
use Slick\Filter\FilterChainInterface;
use Slick\Form\Input\FilterAwareMethods;

/**
 * Filter Aware Methods trait test case
 *
 * @package Slick\Tests\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class FilterAwareMethodsTest extends TestCase
{

    /**
     * @var FilterAwareMethods|MockObject
     */
    protected $element;

    /**
     * Sets the SUT element using the trait
     */
    protected function setUp()
    {
        parent::setUp();
        $class = FilterAwareMethods::class;
        $this->element = $this->getMockBuilder($class)
            ->setMethods(['getRawValue'])
            ->getMockForTrait();
    }

    /**
     * Clear SUT for nex test
     */
    protected function tearDown()
    {
        $this->element = null;
        parent::tearDown();
    }

    /**
     * Should create an empty filter chain if no chin exists
     * @test
     */
    public function getFilerChain()
    {
        $chain = $this->element->getFilterChain();
        $this->assertInstanceOf(FilterChainInterface::class, $chain);
    }

    /**
     * Should pass the raw value through all filters in filter chain
     * @test
     */
    public function filterValue()
    {
        $value = 'test';
        $this->element->expects($this->once())
            ->method('getRawValue')
            ->willReturn($value);
        $chain = $this->getFilterChainMock();
        $chain->expects($this->once())
            ->method('filter')
            ->with($value)
            ->willReturn($value);
        $this->element->setFilterChain($chain);
        $this->assertEquals($value, $this->element->getValue());
    }

    /**
     * Should use the StaticFiler::create() to add the filter
     * @test
     */
    public function addFilter()
    {
        $this->assertSame(
            $this->element,
            $this->element->addFilter('number')
        );
    }

    /**
     * Should raise an exception
     * @test
     * @expectedException \Slick\Form\Exception\InvalidArgumentException
     */
    public function addInvalidFilter()
    {
        $this->element->addFilter('-number-');
    }

    /**
     * Gets mocked filter chain
     *
     * @return MockObject|FilterChainInterface
     */
    protected function getFilterChainMock()
    {
        $class = FilterChainInterface::class;
        $methods = get_class_methods($class);
        /** @var FilterChainInterface|MockObject $chain */
        $chain = $this->getMockBuilder($class)
            ->setMethods($methods)
            ->getMock();
        return $chain;
    }
}
