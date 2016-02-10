<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Renderer;

use Slick\Template\EngineInterface;
use Slick\Template\Template;

/**
 * Creates a Template engine for Form/Renderer
 *
 * @package Slick\Form\Renderer
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
final class TemplateFactory
{

    /**
     * @var EngineInterface
     */
    private static $instance;


    /**
     * Gets the Slick/Form default engine renderer
     *
     * @return EngineInterface
     */
    public static function getEngine()
    {
        if (null === self::$instance) {
            Template::addPath(self::getPath());
            $template = new Template();
            self::$instance = $template->initialize();
        }
        return self::$instance;
    }

    /**
     * Returns the path where HTML templates will live in
     *
     * @return string
     */
    private static function getPath()
    {
        return dirname(dirname(__DIR__)).'/templates';
    }
}