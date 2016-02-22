<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Renderer;

/**
 * Input renderer
 *
 * @package Slick\Form\Renderer
 */
class Input extends Div implements RendererInterface
{

    /**
     * @var string The template file to use in the rendering
     */
    public $template = 'form-inputs/text.twig';

    /**
     * Render the HTML element in the provided context
     *
     * @param array $context
     *
     * @return string The HTML string output
     */
    public function render($context = [])
    {
        if ($element = $this->getElement()) {
            $class = $element->getAttribute('class', false);
            $class .= $class
                ? ' form-control'
                : 'form-control';
            $this->getElement()->setAttribute('class', $class);
        }

        return parent::render($context);
    }
}