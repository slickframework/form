<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Input;

use Slick\Form\ElementInterface;
use Slick\Form\Exception\InvalidArgumentException;
use Slick\Form\InputInterface;
use Slick\Validator\NotEmpty;
use Slick\Validator\StaticValidator;
use Slick\Validator\ValidationChain;
use Slick\Validator\ValidationChainInterface;
use Slick\Validator\ValidatorInterface;
use Slick\Validator\Exception as ValidatorException;

/**
 * Implementation for ValidationAwareInterface
 *
 * @package Slick\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
trait ValidationAwareMethods
{
    /**
     * @var ValidationChainInterface
     */
    protected $validationChain;

    /**
     * @var boolean
     */
    protected $valid = true;

    /**
     * @var array
     */
    protected $context = [];

    /**
     * Gets the value to be validated
     *
     * @return mixed
     */
    abstract public function getValue();

    /**
     * Check if the value is valid
     *
     * The value should pass through all validators in the validation chain
     *
     * @return boolean True if is valid, false otherwise
     */
    public function isValid()
    {
        return $this->valid;
    }

    /**
     * Validates current value so that isValid can retrieve the result of
     * the validation(s)
     *
     * @return self|$this|ValidationAwareInterface
     */
    public function validate()
    {
        $context = array_merge(['input' => $this], $this->context);
        $this->valid = $this->getValidationChain()
            ->validates($this->getValue(), $context);
        return $this;
    }

    /**
     * Returns the validation chain for this input
     *
     * @return ValidationChainInterface
     */
    public function getValidationChain()
    {
        if (null == $this->validationChain) {
            $this->setValidationChain(new ValidationChain());
        }
        return $this->validationChain;
    }

    /**
     * Sets input validation chain
     *
     * @param ValidationChainInterface $chain
     *
     * @return self|$this|ValidationAwareInterface
     */
    public function setValidationChain(ValidationChainInterface $chain)
    {
        $this->validationChain = $chain;
        return $this;
    }

    /**
     * Adds a validator to the validation chain
     *
     * The validator param could be a known validator alias, a FQ
     * ValidatorInterface class name or an object implementing
     * ValidatorInterface.
     *
     * @param string|ValidatorInterface $validator
     * @param string|array $message Error message and possible contexts
     *      variables.
     *
     * @return self|$this|ValidationAwareInterface|ElementInterface
     *
     * @throws InvalidArgumentException If the provided validator is an unknown
     *      validator alias or not a valid class name or the object passed
     *      does not implement the ValidatorInterface interface.
     */
    public function addValidator($validator, $message = null)
    {
        try {
            $msg = $message;
            if (is_array($message)) {
                $msg = array_shift($message);
                $this->context = $message;
            }
            $validator = StaticValidator::create($validator, $msg);
            $this->getValidationChain()
                ->add($validator);
            if ($validator instanceof NotEmpty) {
                $this->setRequired(true);
            }
        } catch (ValidatorException $caught) {
            throw new InvalidArgumentException(
                $caught->getMessage(),
                0,
                $caught
            );
        }
        return $this;
    }

    /**
     * Sets the required flag for this input
     *
     * @param boolean $required
     *
     * @return $this|self|InputInterface
     */
    abstract public function setRequired($required);
}
