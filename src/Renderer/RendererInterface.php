<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Renderer;

use Slick\Form\ElementInterface;

/**
 * HTML element Renderer Interface
 *
 * @package Slick\Form\Renderer
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface RendererInterface
{

    /**
     * Sets the element that to be rendered
     *
     * @param ElementInterface $element
     * @return self|$this|RendererInterface
     */
    public function setElement(ElementInterface $element);

    /**
     * Render the HTML element in the provided context
     *
     * @param array $context
     *
     * @return string The HTML string output
     */
    public function render($context = []);
}