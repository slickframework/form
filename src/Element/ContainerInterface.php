<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Element;

use Slick\Common\Utils\CollectionInterface;
use Slick\Form\ElementInterface;

/**
 * Container Interface: group elements
 *
 * @package Slick\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface ContainerInterface extends CollectionInterface, ElementInterface
{

    /**
     * Checks if all elements are valid
     *
     * @return mixed
     */
    public function isValid();

    /**
     * Adds an element to the container
     *
     * @param ElementInterface $element
     *
     * @return self|$this|ContainerInterface
     */
    public function add(ElementInterface $element);

    /**
     * Gets element by name
     *
     * @param string $name
     *
     * @return null|ElementInterface
     */
    public function get($name);

    /**
     * Sets the values form matched elements
     *
     * The passed array is a key/value array where keys are used to
     * match against element names. It will only assign the value to
     * the marched element only.
     *
     * @param array $values
     *
     * @return self|$this|ContainerInterface
     */
    public function setValues(array $values);
}