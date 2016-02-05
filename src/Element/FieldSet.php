<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Element;

use Slick\Common\Utils\Collection\AbstractCollection;
use Slick\Form\ElementInterface;
use Slick\Form\Input\Text;
use Slick\Form\Input\ValidationAwareInterface;

/**
 * FieldSet
 *
 * @package Slick\Form\Element
 */
class FieldSet extends AbstractCollection implements ContainerInterface
{

    /**
     * Add attribute manipulation methods
     */
    use AttributesAwareMethods;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * Checks if all elements are valid
     *
     * @return mixed
     */
    public function isValid()
    {
        $valid = true;
        foreach ($this->getIterator() as $element) {
            if ($element instanceof ValidationAwareInterface) {
                $valid = $element->isValid()
                    ? $valid
                    : false;
            }
        }
        return $valid;
    }

    /**
     * Adds an element to the container
     *
     * @param ElementInterface $element
     *
     * @return self|$this|ContainerInterface
     */
    public function add(ElementInterface $element)
    {
        $this->data[$element->getName()] = $element;
        return $this;
    }

    /**
     * Gets element by name
     *
     * @param string $name
     *
     * @return null|ElementInterface
     */
    public function get($name)
    {
        $selected = null;
        if (array_key_exists($name, $this->data)) {
            $selected = $this->data[$name];
        }
        return $selected;
    }

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
    public function setValues(array $values)
    {
        foreach ($values as $name => $value) {
            if ($element = $this->get($name)) {
                $element->setValue($value);
            }
        }
        return $this;
    }

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
     * Returns element name.
     *
     * This name can be null however a form or field set will use it
     * in the FormInterface::get() method to retrieve it.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set element name
     *
     * @param string $name
     * @return $this|self|FieldSet
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Sets the value or content of the element
     *
     * @param mixed $value
     *
     * @return self|$this|FieldSet
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Adds an element to the collection
     *
     * @param mixed $offset unused
     * @param ElementInterface $value
     */
    public function offsetSet($offset, $value)
    {
        $this->add($value);
    }
}