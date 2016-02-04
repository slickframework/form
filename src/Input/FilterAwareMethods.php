<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Input;

use Slick\Filter\FilterChain;
use Slick\Filter\FilterChainInterface;
use Slick\Filter\FilterInterface;
use Slick\Filter\StaticFilter;
use Slick\Form\Exception\InvalidArgumentException;
use Slick\Filter\Exception as FilterException;

/**
 * Implementation for FilterAwareInterface
 *
 * @package Slick\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
trait FilterAwareMethods
{

    /**
     * @var FilterChainInterface
     */
    protected $filterChain;

    /**
     * Returns the input value as user entered it, without filtering
     *
     * @return mixed
     */
    abstract public function getRawValue();

    /**
     * Returns the value after filtered on filter chain
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->getFilterChain()
            ->filter($this->getRawValue());
    }



    /**
     * Returns the filter chain for this input
     *
     * @return FilterChainInterface
     */
    public function getFilterChain()
    {
        if (null == $this->filterChain) {
            $this->setFilterChain(new FilterChain());
        }
        return $this->filterChain;
    }

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
    public function addFilter($filter)
    {
        try {
            $this->getFilterChain()
                ->add(StaticFilter::create($filter));
        } catch (FilterException $caught) {
            throw new InvalidArgumentException(
                $caught->getMessage(),
                0,
                $caught
            );
        }
        return $this;
    }

    /**
     * Set input filter chain
     *
     * @param FilterChainInterface $chain
     *
     * @return self|$this|FilterAwareInterface
     */
    public function setFilterChain(FilterChainInterface $chain)
    {
        $this->filterChain = $chain;
        return $this;
    }
}