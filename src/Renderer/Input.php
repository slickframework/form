<?php
/**
 * Created by PhpStorm.
 * User: fsilva
 * Date: 10-02-2016
 * Time: 12:43
 */

namespace Slick\Form\Renderer;


use Slick\Form\InputInterface;

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