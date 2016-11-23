<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Renderer;
use Slick\Form\InputInterface;

/**
 * HTML Checkbox input renderer
 *
 * @package Slick\Form\Renderer
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Checkbox extends Div
{

    /**
     * @var InputInterface
     */
    protected $element;

    /**
     * @var string The template file to use in the rendering
     */
    public $template = 'form-inputs/checkbox.twig';

    /**
     * Returns the elements's label attributes as a string
     *
     * @return string
     */
    public function getLabelAttributes()
    {
        $result = [];
        $label = $this->element->getLabel();
        foreach ($label->getAttributes() as $attribute => $value) {
            if (null === $value) {
                $result[] = $attribute;
                continue;
            }

            $result[] = "{$attribute}=\"{$value}\"";
        }
        return implode(' ', $result);
    }

    /**
     * Returns the elements's attributes as a string
     *
     * @return string
     */
    public function getAttributes()
    {
        $result = [];
        foreach ($this->element->getAttributes() as $attribute => $value) {
            if (null === $value) {
                $result[] = $attribute;
                continue;
            }
            if ($attribute == 'name') continue;
            $result[] = "{$attribute}=\"{$value}\"";
        }
        return implode(' ', $result);
    }
}