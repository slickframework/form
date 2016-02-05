<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Input;

use Slick\Form\InputInterface;

/**
 * Hidden input
 *
 * @package Slick\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Hidden  extends AbstractInput implements InputInterface
{

    /**
     * Crates the input with the attribute type as hidden
     */
    public function __construct()
    {
        $this->setAttribute('type', 'hidden');
    }
}