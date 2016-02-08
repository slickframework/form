<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form\Parser;

use Slick\Form\Exception\InvalidArgumentException;
use Slick\Form\Exception\ParserErrorException;

/**
 * Php form definitions Parser
 *
 * @package Slick\Form\Parser
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class PhpParser extends YamlParser
{

    /**
     * Sets definition data for form creation
     *
     * @param mixed $definitions
     *
     * @return self|$this|ParserInterface
     */
    public function setData($definitions)
    {
        if (is_array($definitions)) {
            $this->parsedData = $definitions;
            return;
        }

        if (!is_file($definitions)) {
            throw new InvalidArgumentException(
                "The form definition file '{$definitions}' does not exists."
            );
        }

        try {
            $this->parsedData = include $definitions;
        } catch (\Exception $caught) {
            throw new ParserErrorException(
                'Error parsing form definitions: '.$caught->getMessage(),
                0,
                $caught
            );
        }
    }
}