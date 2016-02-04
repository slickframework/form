<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Input;

use Slick\Form\Exception\InvalidArgumentException;
use Slick\Validator\ValidationChainInterface;
use Slick\Validator\ValidatorInterface;

/**
 * Validation Aware Interface
 *
 * @package Slick\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface ValidationAwareInterface
{

    /**
     * Check if the value is valid
     *
     * The value should pass through all validators in the validation chain
     *
     * @return boolean True if is valid, false otherwise
     */
    public function isValid();

    /**
     * Returns the validation chain for this input
     *
     * @return ValidationChainInterface
     */
    public function getValidationChain();

    /**
     * Sets input validation chain
     *
     * @param ValidationChainInterface $chain
     *
     * @return self|$this|ValidationAwareInterface
     */
    public function setValidationChain(ValidationChainInterface $chain);

    /**
     * Adds a validator to the validation chain
     *
     * The validator param could be a known validator alias, a FQ
     * ValidatorInterface class name or an object implementing
     * ValidatorInterface.
     *
     * @param string|ValidatorInterface $validator
     * @param string $message Error message
     *
     * @return self|$this|ValidationAwareInterface
     *
     * @throws InvalidArgumentException If the provided validator is an unknown
     *      validator alias or not a valid class name or the object passed
     *      does not implement the ValidatorInterface interface.
     */
    public function addValidator($validator, $message = null);
}