<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Input;

use Slick\Filter\StaticFilter;
use Slick\Form\Input\Filter\Boolean;
use Slick\Form\InputInterface;
use Slick\Form\Renderer\Checkbox as CheckboxRenderer;
use Slick\Form\Utils\AttributesMapInterface;

/**
 * Checkbox input
 *
 * @package Slick\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Checkbox  extends AbstractInput implements InputInterface
{
    /**
     * @var bool
     */
    protected $checked = null;

    /**
     * @var string|mixed
     */
    protected $value = 0;

    /**
     * @var string Renderer class
     */
    protected $rendererClass = CheckboxRenderer::class;

    /**
     * Crates the input with the attribute type as text
     */
    public function __construct()
    {
        $this->setAttribute('type', 'checkbox');
    }

    /**
     * Sets the value of the checkbox
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function setValue($value)
    {
        $this->checked = null;
        return parent::setValue($value);
    }

    /**
     * Check whenever the checkbox state is checked
     *
     * @return bool|mixed
     */
    public function isChecked()
    {
        if (null == $this->checked) {
            $this->checked = StaticFilter::filter(
                Boolean::class,
                $this->getValue()
            );
        }
        return $this->checked;
    }

    /**
     * Get the attributes map collection
     *
     * @return AttributesMapInterface
     */
    public function getAttributes()
    {
        $attributes = parent::getAttributes();
        if ($this->isChecked()) {
            $attributes->set('checked', null);
        }
        return $attributes;
    }


}