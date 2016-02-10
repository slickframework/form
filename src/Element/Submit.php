<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Element;

use Slick\Form\ElementInterface;
use Slick\Form\Renderer\Button as ButtonRenderer;

/**
 * HTML form submit button
 *
 * @package Slick\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Submit extends AbstractElement implements ElementInterface
{

    /**
     * @var string Renderer class
     */
    protected $rendererClass = ButtonRenderer::class;

    /**
     * Submit constructor.
     */
    public function __construct()
    {
        $this->getAttributes()->set('type', 'submit');
    }
}