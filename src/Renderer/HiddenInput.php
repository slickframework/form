<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Renderer;

/**
 * Hidden Input Renderer
 *
 * @package Slick\Form\Renderer
 * @author  Filipe Silva <filipe.silva@sata.pt>
 */
class HiddenInput extends Input implements RendererInterface
{

    /**
     * @var string The template file to use in the rendering
     */
    public $template = 'form-inputs/hidden.twig';
}
