<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Parser;

use Slick\Form\Element\ContainerInterface;

/**
 * Parser Worker Interface: Adds or changes a specific aspect of a from element
 *
 * @package Slick\Form\Parser
 * @author  Filipe Silva<silvam.filipe@gmail.com>
 */
interface WorkerInterface
{

    /**
     * Adds or changes a specific aspect of provided from
     *
     * @param ContainerInterface $form
     * @param array $data
     *
     * @return void
     */
    public static function execute(ContainerInterface $form, array $data);
}