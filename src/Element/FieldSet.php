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
use Slick\Form\Input\ValidationAwareInterface;
use Slick\Form\InputInterface;
use Slick\Form\Renderer\FieldSet as FieldSetRenderer;
use Slick\Form\Renderer\RendererInterface;

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
     * Add render capabilities to element
     */
    use RenderAwareMethods;

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
        $this->validate();
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
        if (null === $element->getName()) {
            $this->data[] = $element;
            return $this;
        }
        $this->data[$element->getName()] = $element;
        return $this;
    }

    /**
     * Gets element by name
     *
     * @param string $name
     *
     * @return null|ElementInterface|InputInterface
     */
    public function get($name)
    {
        $selected = null;
        /** @var ElementInterface|ContainerInterface $element */
        foreach ($this as $element) {
            if ($element->getName() == $name) {
                $selected = $element;
                break;
            }

            if ($element instanceof ContainerInterface) {
                $selected = $element->get($name);
                if (null !== $selected) {
                    break;
                }
            }
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

    /**
     * Gets the HTML renderer for this element
     *
     * @return RendererInterface
     */
    protected function getRenderer()
    {
        return new FieldSetRenderer($this);
    }

    /**
     * Runs validation chain in all its elements
     *
     * @return self|$this|ElementInterface
     */
    public function validate()
    {
        foreach ($this as $element) {

            if (
                $element instanceof ValidationAwareInterface ||
                $element instanceof ContainerInterface
            ) {
                $element->validate();
            }
        }
        return $this;
    }
}