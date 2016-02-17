<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Input;

use Slick\Form\Element\AbstractElement;
use Slick\Form\Element\Label;
use Slick\Form\ElementInterface;
use Slick\Form\Exception\InvalidArgumentException;
use Slick\Form\InputInterface;
use Slick\Form\Renderer\Input;
use Slick\I18n\TranslateMethods;

/**
 * Abstract Input: base input interface implementations
 *
 * @package Slick\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
abstract class AbstractInput extends AbstractElement
{
    /**
     * @var string used in input id generation
     */
    protected static $idPrefix = 'input-';

    /**
     * @var Label|ElementInterface
     */
    protected $label;

    /**
     * @var bool
     */
    protected $required = false;

    /**
     * Add validation methods
     */
    use ValidationAwareMethods;

    /**
     * Add filter methods
     */
    use FilterAwareMethods;

    /**
     * Needed for label translation
     */
    use TranslateMethods;

    /**
     * @var string Renderer class
     */
    protected $rendererClass = Input::class;

    /**
     * Get input name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->getAttribute('name');
    }

    /**
     * Sets input name
     *
     * @param string $name
     *
     * @return self|$this|InputInterface|AbstractInput
     */
    public function setName($name)
    {
        $this->setAttribute('name', $name);
        $this->name = $name;
        if ($label = $this->getLabel()) {
            $this->getLabel()->setAttribute('for', $this->generateId());
        }
        return $this;
    }

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
    public function setLabel($label)
    {
        $this->label = $this->checkLabel($label);
        $this->label->setAttribute('for', $this->generateId());
        return $this;
    }

    /**
     * Gets the input label element
     *
     * @return ElementInterface|Label
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Returns the input value as user entered it, without filtering
     *
     * @return mixed
     */
    public function getRawValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->setAttribute('value', $value);
        $this->valid = null;
        return parent::setValue($value);
    }

    /**
     * Generate input id based on provided name
     *
     * @return string
     */
    protected function generateId()
    {
        $inputId = static::$idPrefix . $this->getName();
        $this->setAttribute('id', $inputId);
        return $inputId;
    }

    /**
     * Check provided label
     *
     * @param string|ElementInterface $label
     *
     * @return ElementInterface|Label
     */
    protected function checkLabel($label)
    {
        if ($label instanceof ElementInterface) {
            return $label;
        }

        return $this->createLabel($this->translate($label));
    }

    /**
     * Creates label from string
     *
     * @param string $label
     *
     * @return ElementInterface|Label
     */
    protected function createLabel($label)
    {
        if (!is_string($label)) {
            throw new InvalidArgumentException(
                "Provided label is not a string or an ElementInterface ".
                "interface object."
            );
        }

        $element = class_exists($label)
            ? $this->createLabelFromClass($label)
            : new Label('', $label);

        return $element;
    }

    /**
     * Instantiates the provided ElementInterface  class
     *
     * @param string $class
     *
     * @return ElementInterface|Label
     */
    protected function createLabelFromClass($class)
    {
        if (! is_subclass_of($class, ElementInterface::class)) {
            throw new InvalidArgumentException(
                "Class '{$class}' does not implements ElementInterface and ".
                "cannot be used as input label."
            );
        }

        $label = new $class('', ucfirst($this->getName()));
        return $label;
    }

    /**
     * Check if this input is required to be filled
     *
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * Sets the required flag for this input
     *
     * @param boolean $required
     *
     * @return $this|self|InputInterface
     */
    public function setRequired($required)
    {
        $this->required = (boolean) $required;
        if ($this->isRequired()) {
            $this->setAttribute('required');
            return $this;
        }

        if ($this->getAttributes()->containsKey('required')) {
                $this->getAttributes()->remove('required');
        }
        return $this;
    }
}
