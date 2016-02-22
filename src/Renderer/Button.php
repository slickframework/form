<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Renderer;

use Slick\I18n\TranslateMethods;

/**
 * HTML Button renderer
 *
 * @package Slick\Form\Renderer
 */
class Button extends Div implements RendererInterface
{

    /**
     * Needed for button translation
     */
    use TranslateMethods;

    /**
     * @var string The template file to use in the rendering
     */
    public $template = 'form-elements/button.twig';

    /**
     * Render the HTML element in the provided context
     *
     * @param array $context
     *
     * @return string The HTML string output
     */
    public function render($context = [])
    {
        $this->element->setValue(
            $this->translate($this->element->getValue())
        );
        return parent::render($context);
    }
}
