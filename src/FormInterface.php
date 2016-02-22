<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form;

use Psr\Http\Message\ServerRequestInterface;
use Slick\Form\Element\ContainerInterface;

/**
 * HTTP Form Interface
 *
 * @package Slick\Form
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface FormInterface extends ContainerInterface
{

    /**
     * Gets the form id
     *
     * @return string
     */
    public function getId();

    /**
     * Sets internal form ID
     *
     * @param string $formId
     *
     * @return self|$this|FormInterface
     */
    public function setId($formId);

    /**
     * Set data to validate and/or populate elements
     *
     * @param array $data
     *
     * @return self|$this|FormInterface
     */
    public function setData($data);

    /**
     * Returns submitted data or current data
     *
     * @return array
     */
    public function getData();

    /**
     * Sets HTTP server request
     *
     * The form data should be populated from this requests.
     *
     * @param ServerRequestInterface $request
     * @return self|$this|FormInterface
     */
    public function setRequest(ServerRequestInterface $request);

    /**
     * Check if for was submitted or not
     *
     * @return boolean
     */
    public function wasSubmitted();
}