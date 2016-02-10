<?php
/**
 * Created by PhpStorm.
 * User: filipesilva
 * Date: 10/02/16
 * Time: 01:16
 */

namespace Slick\Form\Renderer;


class Div extends AbstractRenderer implements RendererInterface
{

    /**
     * @var string The template file to use in the rendering
     */
    public $template = 'form-elements/default.twig';

    /**
     * Render the HTML element in the provided context
     *
     * @param array $context
     *
     * @return string The HTML string output
     */
    public function render($context = [])
    {
        $this->getEngine()->parse($this->template);
        $data = [
            'element' => $this->getElement(),
            'context' => $context,
            'renderer' => $this
        ];
        return $this->getEngine()->process($data);
    }
}