<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form;

/**
 * ValueAwareInterface
 * 
 * @package Slick\Form
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface ValueAwareInterface
{

    /**
     * Gets the value ready to be used in forms
     * 
     * @return mixed
     */
    public function getFormValue();
}