<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Renderer;

/**
 * File renderer
 *
 * @package Slick\Form\Renderer
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class File extends Input implements RendererInterface
{

    /**
     * Render the HTML element in the provided context
     *
     * @param array $context
     *
     * @return string The HTML string output
     */
    public function render($context = [])
    {
        $element = clone $this->element;

        $value = $this->element->getAttribute('value', false);
        if ($value !== false) {
            $this->element->getAttributes()->remove('value');
        }
        $html = parent::render($context);
        $this->element = $element;
        return $html;
    }
}