<?php

/**
 * Test application
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request = new \Slick\Http\PhpEnvironment\Request();
$response = new \Slick\Http\PhpEnvironment\Response();

\Slick\Template\Template::addPath(__DIR__.'/templates');
$template = new \Slick\Template\Template();
/** @var \Slick\Template\TemplateEngineInterface $engine */
$engine = $template->initialize();

$data = [];

$body = new \Slick\Http\Stream('php://memory', 'rw+');
$body->write($engine->parse('form.twig')->process($data));




$response = $response->withBody($body);
$response->send();