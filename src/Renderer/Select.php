<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Renderer;

/**
 * HTML Select renderer
 *
 * @package Slick\Form\Renderer
 */
class Select extends Input
{

    /**
     * @var string The template file to use in the rendering
     */
    public $template = 'form-inputs/select.twig';

    /**
     * Overrides to remove the unnecessary value attribute
     * @param array $context
     * @return string
     */
    public function render($context = [])
    {
        if ($this->getElement()->hasAttribute('value')) {
            $this->getElement()->getAttributes()->remove('value');
        }
        return parent::render($context);
    }
}