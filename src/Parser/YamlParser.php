<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Parser;

use Slick\Form\Exception\InvalidArgumentException;
use Slick\Form\Exception\ParserErrorException;
use Slick\Form\FormInterface;
use Slick\Form\Parser\Worker\AddElements;
use Slick\Form\Parser\Worker\FormId;
use Symfony\Component\Yaml\Yaml;

/**
 * Form Definitions Parser
 *
 * This class is used by the FormRegistry when creating forms
 * based on YAML definitions.
 *
 * @package Slick\Form\Parser
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class YamlParser implements ParserInterface
{

    /** Default form class to create */
    const DEFAULT_FORM_CLASS = 'Slick\Form\Form';

    /**
     * @var array The YAML parser data
     */
    protected $parsedData;

    /**
     * @var WorkerInterface[]
     */
    protected static $workers = [
        'formId' => FormId::class,
        'addElements' => AddElements::class
    ];

    /**
     * Crates a definition parser
     *
     * @param string $definitions The full path for definitions file
     */
    public function __construct($definitions)
    {
        $this->setData($definitions);
    }

    /**
     * Create form using provided definitions
     *
     * @param string $definitions
     *
     * @return FormInterface
     */
    public static function create($definitions)
    {
        $parser = new static($definitions);
        return $parser->getForm();
    }

    /**
     * Gets the resulting form object
     *
     * @return FormInterface
     */
    public function getForm()
    {
        $form = $this->createForm();
        $this->workout($form);
        return $form;
    }

    /**
     * Updates the form with definitions from parsed data
     *
     * @param FormInterface $form
     */
    protected function workout(FormInterface $form)
    {
        foreach (self::$workers as $worker) {
            call_user_func_array(
                [$worker, 'execute'],
                [$form, $this->parsedData]
            );
        }
    }

    /**
     * Creates the form class
     *
     * @return FormInterface
     */
    protected function createForm()
    {
        $class = self::DEFAULT_FORM_CLASS;
        if (array_key_exists('class', $this->parsedData)) {
            $class = $this->checkClass($this->parsedData['class']);
        }

        return new $class;
    }

    protected function checkClass($name)
    {
        if (! class_exists($name)) {
            throw new InvalidArgumentException(
                "The form class '{$name}' does not exists."
            );
        }

        if (! is_subclass_of($name, FormInterface::class)) {
            throw new InvalidArgumentException(
                "The class '{$name}' does not implements the " .
                "FormInterface interface"
            );
        }
        return $name;
    }

    /**
     * Sets definition data for form creation
     *
     * @param mixed $definitions
     *
     * @return self|$this|ParserInterface
     */
    public function setData($definitions)
    {
        if (is_array($definitions)) {
            $this->parsedData = $definitions;
            return;
        }

        if (!is_file($definitions)) {
            throw new InvalidArgumentException(
                "The form definition file '{$definitions}' does not exists."
            );
        }

        try {
            $this->parsedData = Yaml::parse($definitions);
        } catch (\Exception $caught) {
            throw new ParserErrorException(
                'Error parsing form definitions: '.$caught->getMessage(),
                0,
                $caught
            );
        }
    }
}