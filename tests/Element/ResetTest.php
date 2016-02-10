<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Element;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Element\Reset;

/**
 * HTML Reset test case
 *
 * @package Slick\Tests\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class ResetTest extends TestCase
{

    /**
     * @var Reset
     */
    protected $button;

    /**
     * Create the SUT button object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->button = new Reset();
    }

    public function testOutput()
    {
        $this->button->setValue('test');
        $expected = '<button type="reset">test</button>';
        $this->assertEquals($expected, (string) $this->button);
    }
}
