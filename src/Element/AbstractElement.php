<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Element;

use Slick\Form\ElementInterface;
use Slick\Form\Utils\AttributesMap;
use Slick\Form\Utils\AttributesMapInterface;

/**
 * Abstract Element: base element interface implementations
 *
 * @package Slick\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
abstract class AbstractElement
{

    /**
     * Add attribute manipulation methods
     */
    use AttributesAwareMethods;

    /**
     * @var string|mixed
     */
    protected $value;

    /**
     * @var null|string
     */
    protected $name = null;

    /**
     * Gets the element value
     *
     * This value here is just a string and it can be the content that
     * goes inside <label> tags for example.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value or content of the element
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Returns element name
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets element name
     *
     * @param string $name
     *
     * @return $this|self|AbstractElement
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}