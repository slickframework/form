<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Element;

use Slick\Form\Renderer\RendererInterface;

/**
 * Render capabilities for HTML elements
 *
 * @package Slick\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
trait RenderAwareMethods
{

    /**
     * Returns the HTML string for current element
     *
     * @param array $context
     *
     * @return string
     */
    public function render($context = [])
    {
        $this->getRenderer()->setElement($this);
        return $this->getRenderer()->render($context);
    }

    /**
     * Returns the HTML string for this element
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->render();
    }

    /**
     * Gets the HTML renderer for this element
     *
     * @return RendererInterface
     */
    abstract protected function getRenderer();

}