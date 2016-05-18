<?php
/**
 * Created by PhpStorm.
 * User: fsilva
 * Date: 10-02-2016
 * Time: 18:39
 */

namespace Slick\Form\Renderer;


class TextArea extends Input
{

    /**
     * @var string The template file to use in the rendering
     */
    public $template = 'form-inputs/textarea.twig';

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