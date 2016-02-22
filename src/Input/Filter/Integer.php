<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Input\Filter;

use Slick\Filter\Exception;
use Slick\Filter\FilterInterface;

/**
 * Integer filter
 *
 * @package Slick\Form\Input\Filter
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Integer implements FilterInterface
{

    /**
     * Returns the result of filtering $value
     *
     * @param mixed $value
     *
     * @throws Exception\CannotFilterValueException
     *      If filtering $value is impossible.
     *
     * @return mixed
     */
    public function filter($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT);
    }
}