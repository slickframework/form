<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form;

use Slick\Form\Utils\AttributesMapInterface;

/**
 * Element Interface
 *
 * @package Slick\Form
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface ElementInterface
{

    /**
     * Gets the element value
     *
     * This value here is just a string and it can be the content that
     * goes inside <label> tags for example.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Sets the value or content of the element
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function setValue($value);

    /**
     * Set an HTML tag attribute
     *
     * @param string $name
     * @param string $value
     *
     * @return self|$this|ElementInterface
     */
    public function setAttribute($name, $value = null);

    /**
     * Gets the value of the attribute with the provided name
     *
     * If there is no attribute with provided name, the default value
     * SHOULD be returned.
     *
     * @param string      $name
     * @param null|string $default
     *
     * @return null|string
     */
    public function getAttribute($name, $default = null);

    /**
     * Check if the provided attribute is set/exists
     *
     * @param string $name
     *
     * @return boolean True if attribute with name exists, false otherwise
     */
    public function hasAttribute($name);

    /**
     * Get the attributes map collection
     *
     * @return AttributesMapInterface
     */
    public function getAttributes();

    /**
     * Sets the attribute map collection
     *
     * @param AttributesMapInterface $attributes
     *
     * @return self|$this|ElementInterface
     */
    public function setAttributes(AttributesMapInterface $attributes);
}