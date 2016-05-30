<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Element;

use Slick\Form\ElementInterface;
use Slick\Form\Renderer\Div;
use Slick\Form\Renderer\RendererInterface;
use Slick\Form\ValueAwareInterface;

/**
 * Abstract Element: base element interface implementations
 *
 * @package Slick\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
abstract class AbstractElement implements ElementInterface
{

    /**
     * @var array
     */
    protected $settings = [
        'multiple' => false
    ];

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
     * @var bool
     */
    protected $rendering = false;

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
        if ($value instanceof ValueAwareInterface) {
            $this->value = $value->getFormValue();
        }
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

    /**
     * Set other input settings
     *
     * @param array $settings
     * @return self|AbstractElement
     */
    public function setSettings(array $settings)
    {
        $this->settings = array_merge($this->settings, $settings);
        return $this;
    }

    /**
     * Set rendering state
     *
     * @param bool $state
     *
     * @return self|$this|AbstractElement
     */
    public function setRendering($state)
    {
        $this->rendering = $state;
        return $this;
    }

    /**
     * Check if input is being rendered
     *
     * @return boolean
     */
    public function isRendering()
    {
        return $this->rendering;
    }
}