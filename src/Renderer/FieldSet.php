<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Renderer;

/**
 * HTML FieldSet renderer
 *
 * @package Slick\Form\Renderer
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class FieldSet extends Div implements RendererInterface
{

    /**
     * @var string The template file to use in the rendering
     */
    public $template = 'form-elements/fieldset.twig';
}