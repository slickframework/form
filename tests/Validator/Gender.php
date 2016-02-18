<?php
/**
 * Created by PhpStorm.
 * User: filipesilva
 * Date: 17/02/16
 * Time: 22:38
 */

namespace Slick\Tests\Form\Validator;


use Slick\Validator\AbstractValidator;
use Slick\Validator\ValidatorInterface;

class Gender extends AbstractValidator implements ValidatorInterface
{

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * The context specified can be used in the validation process so that
     * the same value can be valid or invalid depending on that data.
     *
     * @param mixed $value
     * @param array|mixed $context
     *
     * @return bool
     */
    public function validates($value, $context = [])
    {
        $result = in_array($value, ['M', 'F']);
        if (! $result) {
            $this->addMessage($this->messageTemplate, $value);
        }
        return $result;
    }
}