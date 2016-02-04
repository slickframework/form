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
use Slick\Form\Input\ValidationAwareMethods;
use Slick\Validator\ValidationChainInterface;

/**
 * Validation Aware Methods trait test case
 *
 * @package Slick\Tests\Form\Input
 */
class ValidationAwareMethodsTest extends TestCase
{

    /**
     * @var ValidationAwareMethods|MockObject
     */
    protected $element;

    /**
     * Creates the SUT trait containing object
     */
    protected function setUp()
    {
        parent::setUp();
        $class = ValidationAwareMethods::class;
        $this->element = $this->getMockBuilder($class)
            ->setMethods(['getValue'])
            ->getMockForTrait();
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
     * Should create a new validation chain if not present
     * @test
     */
    public function getValidationChain()
    {
        $chain = $this->element->getValidationChain();
        $this->assertInstanceOf(ValidationChainInterface::class, $chain);
    }

    /**
     * Should pass the value through the validation chain
     * @test
     */
    public function checkValidity()
    {
        $value = 'test';
        $this->element->expects($this->once())
            ->method('getValue')
            ->willReturn($value);
        $chain = $this->getValidationMock();
        $chain->expects($this->once())
            ->method('validates')
            ->with($value, $this->element)
            ->willReturn(true);
        $this->element->setValidationChain($chain);
        $this->assertTrue($this->element->isValid());
    }

    /**
     * Should use the StaticValidator::create() add a validator
     * @test
     */
    public function addValidator()
    {
        $this->assertSame(
            $this->element,
            $this->element->addValidator('notEmpty', 'Test')
        );
    }

    /**
     * Should raise an exception
     * @test
     * @expectedException \Slick\Form\Exception\InvalidArgumentException
     */
    public function addInvalidValidator()
    {
        $this->element->addValidator('unknown--', 'Test');
    }

    /**
     * Get validation chain mock
     *
     * @return MockObject|ValidationChainInterface
     */
    protected function getValidationMock()
    {
        $class = ValidationChainInterface::class;
        $methods = get_class_methods($class);
        /** @var ValidationChainInterface|MockObject $chain */
        $chain = $this->getMockBuilder($class)
            ->setMethods($methods)
            ->getMock();
        return $chain;
    }
}