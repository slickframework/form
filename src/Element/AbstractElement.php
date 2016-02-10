<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Element;

use Slick\Form\Renderer\Div;
use Slick\Form\Renderer\RendererInterface;

/**
 * Abstract Element: base element interface implementations
 *
 * @package Slick\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
abstract class AbstractElement
{

    /**
     * Add attribute manipulation methods
     */
    use AttributesAwareMethods;

    /**
     * Add render capabilities to element
     */
    use RenderAwareMethods;

    /**
     * @var string|mixed
     */
    protected $value;

    /**
     * @var null|string
     */
    protected $name = null;

    /**
     * @var string Renderer class
     */
    protected $rendererClass = Div::class;

    /**
     * @var RendererInterface
     */
    protected $renderer;

    /**
     * Gets the element value
     *
     * This value here is just a string and it can be the content that
     * goes inside <label> tags for example.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the value or content of the element
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Returns element name
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets element name
     *
     * @param string $name
     *
     * @return $this|self|AbstractElement
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets the HTML renderer for this element
     *
     * @return RendererInterface
     */
    protected function getRenderer()
    {
        if (null === $this->renderer) {
            $this->setRenderer(new $this->rendererClass());
        }
        return $this->renderer;
    }

    /**
     * Sets internal renderer
     *
     * @param RendererInterface $renderer
     *
     * @return $this|self|AbstractElement
     */
    protected function setRenderer(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
        return $this;
    }
}