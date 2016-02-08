<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Input;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Input\File;

/**
 * HTML File input test case
 *
 * @package Slick\Tests\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class FileTest extends TestCase
{

    /**
     * Should create input with attribute type = file
     * @test
     */
    public function createInput()
    {
        $password = new File();
        $this->assertEquals('file', $password->getAttribute('type'));
    }
}
