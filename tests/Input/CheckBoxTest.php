<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Input;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Element\Label;
use Slick\Form\Input\Checkbox;

/**
 * Checkbox input test case
 *
 * @package Slick\Tests\Form\Input
 */
class CheckboxTest extends TestCase
{

    /**
     * Should create input with attribute type = password
     * @test
     */
    public function createInput()
    {
        $checkbox = new Checkbox();
        $this->assertEquals('checkbox', $checkbox->getAttribute('type'));
    }

    public function testOutput()
    {
        $label = new Label('foo', 'Check this!');
        $label->setAttribute('class', 'normal-label');
        $label->setAttribute('ng-test-controller');
        $checkbox = new Checkbox();
        $checkbox->setName('public')
            ->setValue(true)
            ->setLabel($label)
            ->setAttribute('class', 'user-ctrl');
        $expected = <<<EOHTML
<div class="checkbox">
    <label for="input-public" class="normal-label" ng-test-controller>
        <input type="checkbox" name="public" value="1" checked id="input-public" class="user-ctrl"> Check this!
    </label>
</div>
EOHTML;
        $this->assertEquals($expected, $checkbox->render());

    }
}
