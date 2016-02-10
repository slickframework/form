<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Renderer;

use Slick\Form\ElementInterface;
use Slick\Template\EngineInterface;

/**
 * AbstractRenderer: base renderer
 *
 * @package Slick\Form\Renderer
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
abstract class AbstractRenderer
{

    /**
     * @var ElementInterface
     */
    protected $element;

    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * Returns current element
     *
     * @return ElementInterface
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * Sets HTML element to render
     *
     * @param ElementInterface $element
     *
     * @return $this|self|AbstractRenderer
     */
    public function setElement(ElementInterface $element)
    {
        $this->element = $element;
        return $this;
    }

    /**
     * Returns the current template engine
     *
     * If no template is provided a new one is created with default settings.
     *
     * @return EngineInterface
     */
    public function getEngine()
    {
        if (null === $this->engine) {
            $this->setEngine(TemplateFactory::getEngine());
        }
        return $this->engine;
    }

    /**
     * Sets current template engine
     *
     * @param EngineInterface $engine
     *
     * @return $this|self|AbstractRenderer
     */
    public function setEngine($engine)
    {
        $this->engine = $engine;
        return $this;
    }

}