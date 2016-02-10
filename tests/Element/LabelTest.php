<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Element;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Element\Label;

/**
 * Label Element Test case
 *
 * @package Slick\Tests\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class LabelTest extends TestCase
{

    /**
     * @var Label
     */
    protected $label;

    /**
     * Sets the SUT label object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->label = new Label('inputId', 'test');
    }

    /**
     * Clear SUT for next test
     */
    protected function tearDown()
    {
        $this->label = null;
        parent::tearDown();
    }

    public function testValue()
    {
        $this->assertEquals('test', $this->label->getValue());
    }

    public function testAttributeFor()
    {
        $this->assertEquals('inputId', $this->label->getAttribute('for', ''));
    }

    public function testOutput()
    {
        $expected = '<label for="" ></label>';
        $this->assertEquals($expected, $this->label->render());
    }
}
