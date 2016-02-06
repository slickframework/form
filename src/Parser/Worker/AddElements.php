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
     * @param $element
     * @return ElementInterface
     */
    protected static function create($element)
    {
        $class = self::getClassName($element['type']);
        $object = new $class;
        if ($object instanceof ContainerInterface) {
            static::execute($object, $element);
        }
        return $object;
    }

    protected static function populateInputs($input, $data)
    {
        if ($input instanceof InputInterface) {
            self::addLabel($input, $data);
            self::addValidators($input, $data);
            self::setFilters($input, $data);
        }

        self::populateElement($input, $data);
    }

    protected static function populateElement(ElementInterface $elm, $data)
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

    protected static function setValue(ElementInterface $elm, $data)
    {
        if (isset($data['value'])) {
            $elm->setValue($data['value']);
        }
    }

    protected static function getClassName($type)
    {
        return self::$elements[$type];
    }

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

    protected static function addValidators(InputInterface $input, array $data)
    {
        $hasValidators = isset($data['validates']) && is_array($data['validates']);
        if (! $hasValidators) {
            return;
        }

        foreach ($data['validates'] as $validator => $message) {
            $input->addValidator($validator, $message);
        }
    }

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
        self::populateElement($label, $data);
        $input->setLabel($label);
    }


}