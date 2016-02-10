<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Input;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Input\TextArea;

/**
 * HTML TextArea input test case
 *
 * @package Slick\Tests\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class TextAreaTest extends TestCase
{

    /**
     * @var TextArea
     */
    protected $textArea;

    /**
     * Sets the SUT select object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->textArea = new TextArea();
    }

    protected function tearDown()
    {
        $this->textArea = null;
        parent::tearDown();
    }

    public function testNoValueAttribute()
    {
        $this->textArea->setValue('test');
        $this->assertFalse($this->textArea->getAttributes()->containsKey('value'));
    }
}
