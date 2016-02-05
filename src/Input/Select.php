<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Input;

use Slick\Form\Element\ChoiceAwareElementInterface;
use Slick\Form\Element\ChoiceAwareElementMethods;
use Slick\Form\InputInterface;

/**
 * Select input
 *
 * @package Slick\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Select extends AbstractInput implements
    InputInterface,
    ChoiceAwareElementInterface
{

    /**
     * ChoiceAwareElementInterface implementation methods
     */
    use ChoiceAwareElementMethods;


}