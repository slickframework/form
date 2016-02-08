<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Parser\Worker;

use Slick\Form\Element\Button;
use Slick\Form\Element\ContainerInterface;
use Slick\Form\Element\FieldSet;
use Slick\Form\Element\Label;
use Slick\Form\Element\Reset;
use Slick\Form\Element\Submit;
use Slick\Form\ElementInterface;
use Slick\Form\Exception\InvalidArgumentException;
use Slick\Form\Input\Checkbox;
use Slick\Form\Input\File;
use Slick\Form\Input\Hidden;
use Slick\Form\Input\Password;
use Slick\Form\Input\Select;
use Slick\Form\Input\Text;
use Slick\Form\Input\TextArea;
use Slick\Form\InputInterface;
use Slick\Form\Parser\WorkerInterface;

/**
 * Add Elements to the form
 *
 * @package Slick\Form\Parser\Worker
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class AddElements implements WorkerInterface
{
    /**
     * @var array Available form elements
     */
    public static $elements = [
        'button'   => Button::class,
        'fieldset' => FieldSet::class,
        'label'    => Label::class,
        'reset'    => Reset::class,
        'submit'   => Submit::class,
        'checkbox' => Checkbox::class,
        'hidden'   => Hidden::class,
        'password' => Password::class,
        'select'   => Select::class,
        'text'     => Text::class,
        'textarea' => TextArea::class,
        'file'     => File::class
    ];

    /**
     * @var array List of validators that adds required attribute to input
     */
    public static $triggerRequired = [
        'notEmpty', 'email', 'url'
    ];

    /**
     * Adds or changes a specific aspect of provided from
     *
     * @param ContainerInterface $form
     * @param array $data
     *
     * @return void
     */
    public static function execute(ContainerInterface $form, array $data)
    {
        $hasElements = isset($data['elements']) && is_array($data['elements']);
        if (!$hasElements) {
            return;
        }

        foreach ($data['elements'] as $name => $element) {
            $input = self::create($element);
            $input->setName($name);
            self::populateInputs($input, $element);
            $form->add($input);
        }
    }

    /**
     * Recursively creates the elements to add to the form
     *
     * @param array $element
     *
     * @return ElementInterface
     */
    protected static function create(array $element)
    {
        $class = self::getClassName($element['type']);
        $object = new $class;
        if ($object instanceof ContainerInterface) {
            static::execute($object, $element);
        }
        return $object;
    }

    /**
     * Sets the properties and dependencies for input elements
     *
     * @param ElementInterface $input
     * @param array $data
     */
    protected static function populateInputs(
        ElementInterface $input, array $data
    ) {
        if ($input instanceof InputInterface) {
            self::addLabel($input, $data);
            self::addValidators($input, $data);
            self::setFilters($input, $data);
        }

        self::populateElement($input, $data);
    }

    /**
     * Sets the properties and dependencies for HTML elements
     *
     * @param ElementInterface $elm
     * @param array $data
     */
    protected static function populateElement(ElementInterface $elm, array $data)
    {
        self::setValue($elm, $data);

        $hasAttributes = isset($data['attributes'])
            && is_array($data['attributes']);
        if (! $hasAttributes) {
            return;
        }

        foreach ($data['attributes'] as $attribute => $value) {
            $elm->setAttribute($attribute, $value);
        }
    }

    /**
     * Adds the value to the element
     *
     * @param ElementInterface $elm
     * @param array $data
     */
    protected static function setValue(ElementInterface $elm, $data)
    {
        if (isset($data['value'])) {
            $elm->setValue($data['value']);
        }
    }

    /**
     * Check the element alias or FQ class name
     *
     * @param string $type
     *
     * @return string The Element class name
     */
    protected static function getClassName($type)
    {
        if (in_array($type, array_keys(self::$elements))) {
            $type = self::$elements[$type];
        }

        if (!class_exists($type)) {
            throw new InvalidArgumentException(
                "Input class '{$type}' does not exists."
            );
        }

        if (! is_subclass_of($type, ElementInterface::class)) {
            throw new InvalidArgumentException(
                "The class '{$type}' does not implement the " .
                "Slick\\Form\\ElementInterface interface."
            );
        }

        return $type;
    }

    /**
     * Add filter to the input filter chain
     *
     * @param InputInterface $input
     * @param array $data
     */
    protected static function setFilters(InputInterface $input, array $data)
    {
        $hasFilters = isset($data['filters']) && is_array($data['filters']);
        if (!$hasFilters) {
            return;
        }

        foreach ($data['filters'] as $filter) {
            $input->addFilter($filter);
        }
    }

    /**
     * Add validators to the input validator chain
     *
     * @param InputInterface $input
     * @param array $data
     */
    protected static function addValidators(InputInterface $input, array $data)
    {
        $hasValidators = isset($data['validates']) && is_array($data['validates']);
        if (! $hasValidators) {
            return;
        }

        foreach ($data['validates'] as $validator => $message) {
            self::checkIfRequired($validator, $input);
            $input->addValidator($validator, $message);
        }
    }

    /**
     * Adds the html Label element to input
     *
     * @param InputInterface $input
     * @param array $data
     */
    protected static function addLabel(InputInterface $input, array $data)
    {
        if (!isset($data['label'])) {
            return;
        }
        if (is_string($data['label'])) {
            $input->setLabel($data['label']);
            return;
        }

        $label = new Label('', $data['label']['value']);
        self::populateElement($label, $data['label']);
        $input->setLabel($label);
    }

    /**
     * Check if validator triggers the required attribute
     *
     * @param string $name Validator name
     * @param InputInterface $input
     */
    protected static function checkIfRequired($name, InputInterface $input)
    {
        if (in_array($name, self::$triggerRequired)) {
            $input->setAttribute('required');
        }
    }

}