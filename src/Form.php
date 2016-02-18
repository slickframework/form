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
use Slick\Form\Element\FieldSet;
use Slick\Form\Element\RenderAwareMethods;
use Slick\Form\Input\File;
use Slick\Form\Renderer\Form as FormRenderer;
use Slick\Form\Renderer\RendererInterface;

/**
 * HTTP Form
 *
 * @package Slick\Form
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class Form extends FieldSet implements FormInterface
{

    /**
     * @var string Form id
     */
    protected $id;

    /**
     * Add render capabilities to element
     */
    use RenderAwareMethods;

    /**
     * Creates a form with basic attributes
     */
    public function __construct()
    {
        parent::__construct();
        $this->setAttribute('action', '')
            ->setAttribute('method', 'post');
    }

    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * Set data to validate and/or populate elements
     *
     * @param array $data
     *
     * @return self|$this|FormInterface
     */
    public function setData($data)
    {
        $this->setValues($data);
        return $this;
    }

    /**
     * Returns submitted data or current data
     *
     * @return array
     */
    public function getData()
    {
        $data = [];
        $this->getElementData($this, $data);
        return $data;
    }

    /**
     * Sets HTTP server request
     *
     * The form data should be populated from this requests.
     *
     * @param ServerRequestInterface $request
     * @return self|$this|FormInterface
     */
    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * Recursively collects all posted data
     *
     * @param ContainerInterface $container
     * @param array $data
     */
    protected function getElementData(
        ContainerInterface $container, &$data = []
    ) {
         foreach ($container as $element) {
             if ($element instanceof InputInterface) {
                 $data[$element->getName()] = $element->getValue();
                 continue;
             }

             if ($element instanceof ContainerInterface) {
                 $this->getElementData($element, $data);
                 continue;
             }
        }
    }

    /**
     * Gets the HTML renderer for this element
     *
     * @return RendererInterface
     */
    protected function getRenderer()
    {
        return new FormRenderer($this);
    }

    /**
     * Gets the form id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets internal form ID
     *
     * @param string $formId
     *
     * @return self|$this|FormInterface
     */
    public function setId($formId)
    {
        $this->id = $formId;
        return $this;
    }

    /**
     * Adds an element to the container
     *
     * @param ElementInterface $element
     *
     * @return self|$this|ContainerInterface
     */
    public function add(ElementInterface $element)
    {
        if ($element instanceof File) {
            $this->setAttribute('enctype', 'multipart/form-data');
        }
        return parent::add($element);
    }
}