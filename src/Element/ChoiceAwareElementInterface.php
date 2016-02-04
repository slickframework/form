<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Element;

/**
 * Choice Aware Element Interface
 *
 * @package Slick\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface ChoiceAwareElementInterface
{

    /**
     * Sets element options
     *
     * @param array $options
     *
     * @return self|$this|ChoiceAwareElementInterface
     */
    public function setOptions(array $options);

    /**
     * Get element options
     *
     * @return array
     */
    public function getOptions();

    /**
     * Add an option to the options list
     *
     * @param string $key
     * @param string $value
     *
     * @return self|$this|ChoiceAwareElementInterface
     */
    public function addOption($key, $value);
}
