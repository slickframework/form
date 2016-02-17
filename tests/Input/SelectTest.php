<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Input;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Input\Select;

/**
 * SelectTest
 *
 * @package Slick\Tests\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class SelectTest extends TestCase
{

    /**
     * @var Select
     */
    protected $select;

    /**
     * Sets the SUT select object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->select = new Select();
    }

    protected function tearDown()
    {
        $this->select = null;
        parent::tearDown();
    }

    public function testNoValueAttribute()
    {
        $this->select->setValue('test');
        $this->assertFalse($this->select->getAttributes()->containsKey('value'));
    }

    public function testOutput()
    {
        $expected = <<<HTML
<div class="form-group">
    <label for="input-options">Options <span class="required">*</span></label>
    <select name="options" required id="input-options" class="form-control">
        <option value="1">1</option>
        <option selected value="2">2</option>
        </select>
</div>
HTML;
        $this->select
            ->setValue(2)
            ->setOptions([1 => 1, 2 => 2])
            ->setName('options')
            ->setRequired(true)
            ->setLabel('Options');
        $this->assertEquals($expected, $this->select->render());

    }
}
