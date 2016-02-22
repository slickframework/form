<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Input;

use Slick\Form\InputInterface;
use Slick\Form\Renderer\File as FileRenderer;

/**
 * HTML File input
 *
 * @package Slick\Form\Input
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class File extends AbstractInput implements InputInterface
{

    /**
     * @var string Renderer class
     */
    protected $rendererClass = FileRenderer::class;

    /**
     * Crates the input with the attribute type as text
     */
    public function __construct()
    {
        $this->setAttribute('type', 'file');
    }
}