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
        $file = new File();
        $this->assertEquals('file', $file->getAttribute('type'));
    }

   public function testOutput()
   {
       $expected = <<<EOHTML
<div class="form-group">
    <label for="input-picture" class="control-label">Profile picture</label>
    <input type="file" name="picture" id="input-picture" class="form-control">
</div>
EOHTML;

       $file = new File();
       $file
           ->setValue((object)[])
           ->setName('picture')
           ->setLabel('Profile picture');
       $this->assertEquals($expected, $file->render());
   }
}
