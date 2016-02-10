<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Renderer;

/**
 * HTML Select renderer
 *
 * @package Slick\Form\Renderer
 */
class Select extends Input
{

    /**
     * @var string The template file to use in the rendering
     */
    public $template = 'form-inputs/select.twig';
}