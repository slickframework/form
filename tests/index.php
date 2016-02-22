<?php

/**
 * Test application
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

use Slick\I18n\Translator;

// Set locale based on the browser accept language
$locale = 'pt_PT';

Translator::getInstance()
    ->setBasePath(__DIR__.'/i18n/')
    ->setLocale($locale)
    ->setType(Translator::TYPE_PHP_ARRAY);

// Configure the translator object

// Set PHP environment locale
setlocale(LC_ALL, $locale);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request = new \Slick\Http\PhpEnvironment\Request();
$response = new \Slick\Http\PhpEnvironment\Response();

\Slick\Template\Template::addPath(__DIR__.'/templates');
$template = new \Slick\Template\Template(
    [
        'engine' => \Slick\Template\Template::ENGINE_TWIG,
        'options' => [
            'debug' => true
        ]
    ]
);
/** @var \Slick\Template\TemplateEngineInterface $engine */
$engine = $template->initialize();

$data = [];



$form = \Slick\Form\FormRegistry::getForm(__DIR__.'/forms/full-form.yml');

$form->setRequest($request);
$submitted = false;
if ($form->wasSubmitted()) {
    $submitted = true;
    if ($form->isValid()) {

    }
}
$data = compact('form','submitted');

$body = new \Slick\Http\Stream('php://memory', 'rw+');
$body->write($engine->parse('form.twig')->process($data));




$response = $response->withBody($body);
$response->send();