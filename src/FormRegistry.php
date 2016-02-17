<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Form;

use League\Event\Emitter;
use League\Event\EmitterInterface;
use Slick\Form\Parser\ParserInterface;
use Slick\Form\Parser\PhpParser;
use Slick\Form\Parser\YamlParser;

/**
 * Form Registry and factory class
 *
 * @package Slick\Form
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
final class FormRegistry extends Emitter implements EmitterInterface
{
    const PARSER_YAML = 'yaml';
    const PARSER_PHP = 'php';

    /**
     * @var string parser type
     */
    private $parser;

    /**
     * @var FormRegistry
     */
    private static $instance;

    /**
     * FormRegistry constructor, singleton pattern
     */
    private function __construct()
    {
        // Prevent creation, allowing for singleton pattern
    }

    /**
     * @var array List of known parser types
     */
    private static $knownParsers = [
        self::PARSER_YAML => YamlParser::class,
        self::PARSER_PHP => PhpParser::class
    ];

    /**
     * Generates a for for the provided definitions file
     *
     * @param string $defFile The path to the form definition file
     * @param string $type    Parser type
     *
     * @return FormInterface
     */
    public function get($defFile, $type = self::PARSER_YAML)
    {
        $this->parser = $type;
        $parserClass = self::$knownParsers[$this->parser];
        /** @var ParserInterface $parser */
        $parser = new $parserClass($defFile);
        $form = $parser->getForm();
        $this->emit('form.created', $form);
        return $form;
    }

    /**
     * Returns a self instance
     *
     * @return FormRegistry|static
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new static;
        }
        return self::$instance;
    }

    /**
     * Generates a for for the provided definitions file
     *
     * @param string $defFile The path to the form definition file
     * @param string $type    Parser type
     *
     * @return FormInterface
     */
    public static function getForm($defFile, $type = self::PARSER_YAML)
    {
        return self::getInstance()->get($defFile, $type);
    }
}