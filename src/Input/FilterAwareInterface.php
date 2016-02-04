<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Input;

use Slick\Filter\FilterChainInterface;
use Slick\Filter\FilterInterface;
use Slick\Form\Exception\InvalidArgumentException;

/**
 * Filter Aware Interface
 *
 * @package Slick\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface FilterAwareInterface
{

    /**
     * Returns the value after filtered on filter chain
     *
     * @return mixed
     */
    public function getValue();



    /**
     * Returns the filter chain for this input
     *
     * @return FilterChainInterface
     */
    public function getFilterChain();

    /**
     * Adds a filter to the filter chain
     *
     * The filter param could be a known filter alias, a FQ FilterInterface
     * class name or an object implementing FilterInterface.
     *
     * @param string|FilterInterface $filter
     *
     * @return self|$this|FilterAwareInterface
     *
     * @throws InvalidArgumentException If the provided filter is an unknown
     *      filter alias or not a valid class name or the object passed
     *      does not implement the FilterInterface interface.
     */
    public function addFilter($filter);

    /**
     * Set input filter chain
     *
     * @param FilterChainInterface $chain
     *
     * @return self|$this|FilterAwareInterface
     */
    public function setFilterChain(FilterChainInterface $chain);
}