<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Element;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Element\ChoiceAwareElementMethods;

/**
 * Choice Aware Element Methods test case
 *
 * @package Slick\Tests\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class ChoiceAwareElementMethodsTest extends TestCase
{

    /**
     * @var ChoiceAwareElementMethods
     */
    protected $element;

    /**
     * Set the SUT element using the trait
     */
    protected function setUp()
    {
        parent::setUp();
        $this->element = $this->getMockForTrait(
            ChoiceAwareElementMethods::class
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
     * Should add an entry to the options array under the provided key
     * @test
     */
    public function setOption()
    {
        $expected = ['foo' => 'bar'];
        $this->assertSame(
            $this->element,
            $this->element->addOption('foo', 'bar')
        );
        $this->assertEquals($expected, $this->element->getOptions());
    }

    /**
     * Should replace the entire options array
     * @test
     */
    public function setOptions()
    {
        $expected = ['foo' => 'bar'];
        $this->element->setOptions($expected);
        $this->assertEquals($expected, $this->element->getOptions());
    }
}