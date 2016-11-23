<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form;

use Slick\Form\Exception\InvalidArgumentException;
use Slick\Form\Input\FilterAwareInterface;
use Slick\Form\Input\ValidationAwareInterface;

/**
 * HTML From Input Interface
 *
 * @package Slick\Form
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface InputInterface extends
    ElementInterface,
    ValidationAwareInterface,
    FilterAwareInterface
{

    /**
     * Get input name
     *
     * @return mixed
     */
    public function getName();

    /**
     * Sets the input label
     *
     * Label parameter can be a string or a element interface.
     * If a string is provided then an ElementInterface MUST be created.
     * This element MUST result in a <label> HTML tag when rendering and
     * as you may define your own implementation it is advisable that you
     * use the Slick\Form\Element\Label object.
     *
     * @param string|ElementInterface $label
     *
     * @return self|$this|InputInterface
     *
     * @throws InvalidArgumentException If the provided label is not a string
     *      or is not an object of a class implementing the ElementInterface.
     */
    public function setLabel($label);

    /**
     * Gets the input label element
     *
     * @return ElementInterface
     */
    public function getLabel();

    /**
     * Returns the input value as user entered it, without filtering
     *
     * @return mixed
     */
    public function getRawValue();

    /**
     * Check if this input is required to be filled
     *
     * @return bool
     */
    public function isRequired();

    /**
     * Sets the required flag for this input
     *
     * @param boolean $required
     *
     * @return $this|self|InputInterface
     */
    public function setRequired($required);
    
    /**
     * Check if this input is for multiple usage
     *
     * @return boolean
     */
    public function isMultiple();

    /**
     * If input is multiple get the instance it belongs
     *
     * @return int
     */
    public function getInstance();

    /**
     * If input is multiple get the instance value of it
     *
     * @return mixed
     */
    public function getInstanceValue();

}
