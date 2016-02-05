<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Element;

/**
 * Choice Aware Element Methods trait
 *
 * @package Slick\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
trait ChoiceAwareElementMethods
{

    /**
     * @var array List of options
     */
    protected $options = [];

    /**
     * Sets element options
     *
     * @param array $options
     *
     * @return self|$this|ChoiceAwareElementInterface
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Get element options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Add an option to the options list
     *
     * @param string $key
     * @param string $value
     *
     * @return self|$this|ChoiceAwareElementInterface
     */
    public function addOption($key, $value)
    {
        $this->options[$key] = $value;
        return $this;
    }
}