<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Input\Filter;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Input\Filter\Integer;

/**
 * Integer filter test case
 *
 * @package Slick\Tests\Form\Input\Filter
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class IntegerTest extends TestCase
{

    public function testFilter()
    {
        $integer = new Integer;
        $this->assertTrue(is_integer($integer->filter('-125')));
    }
}
