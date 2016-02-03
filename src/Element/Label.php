<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Element;

use Slick\Form\ElementInterface;

/**
 * HTML Label element
 *
 * @package Slick\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Label extends AbstractElement implements ElementInterface
{

    /**
     * Label constructor.
     *
     * @param string $inputId
     * @param string $value
     */
    public function __construct($inputId, $value)
    {
        $this->setValue($value);
        $this->getAttributes()->set('for', $inputId);
    }
}