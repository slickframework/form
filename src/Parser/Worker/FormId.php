<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Parser\Worker;

use Slick\Form\Element\ContainerInterface;
use Slick\Form\FormInterface;
use Slick\Form\Input\Hidden;
use Slick\Form\Parser\WorkerInterface;

/**
 * Adds form id to the form
 *
 * @package Slick\Form\Parser\Worker
 */
class FormId implements WorkerInterface
{

    /**
     * Adds or changes a specific aspect of provided from
     *
     * @param ContainerInterface|FormInterface $form
     * @param array $data
     *
     * @return void
     */
    public static function execute(ContainerInterface $form, array $data)
    {
        $input = new Hidden();
        $input->setValue($data['id'])
            ->setName('form-id');
        if ($form instanceof FormInterface) {
            $form->setId($data['id']);
        }
        $form->add($input);
    }
}