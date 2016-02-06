<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Parser;

use Slick\Form\FormInterface;

/**
 * Definitions Parser Interface
 *
 * @package Slick\Form\Parser
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
interface ParserInterface
{

    /**
     * Create form using provided definitions
     *
     * @param string $definitions
     *
     * @return FormInterface
     */
    public static function create($definitions);

    /**
     * Gets the resulting form object
     *
     * @return FormInterface
     */
    public function getForm();

    /**
     * Sets definition data for form creation
     *
     * @param mixed $definitions
     *
     * @return self|$this|ParserInterface
     */
    public function setData($definitions);
}
