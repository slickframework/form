<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Input;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Input\Hidden;

/**
 * Hidden input test case
 *
 * @package Slick\Tests\Form\Input
 */
class HiddenTest extends TestCase
{

    /**
     * Should create input with attribute type = password
     * @test
     */
    public function createInput()
    {
        $password = new Hidden();
        $this->assertEquals('hidden', $password->getAttribute('type'));
    }
}
