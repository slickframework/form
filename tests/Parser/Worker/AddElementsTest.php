<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Parser\Worker;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Element\FieldSet;
use Slick\Form\ElementInterface;
use Slick\Form\Form;
use Slick\Form\InputInterface;
use Slick\Form\Parser\Worker\AddElements;
use Slick\Validator\ValidationChainInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Add Elements test case
 *
 * @package Slick\Tests\Form\Parser\Worker
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class AddElementsTest extends TestCase
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * Creates the form using the worker
     */
    protected function setUp()
    {
        parent::setUp();
        $data = Yaml::parse(dirname(dirname(__DIR__)).'/forms/login.yml');
        $this->form = new Form();
        AddElements::execute($this->form, $data);
    }

    /**
     * Clears for next test
     */
    protected function tearDown()
    {
        $this->form = null;
        parent::tearDown();
    }

    public function testCreateEmptyForm()
    {
        $this->form = new Form();
        AddElements::execute($this->form, ['id' => 'test']);
        $this->assertEmpty($this->form->getData());
    }

    public function testFormInput()
    {
        $input = $this->form->get('username');
        $this->assertInstanceOf(InputInterface::class, $input);
        return $input;
    }

    /**
     * @param InputInterface $input
     * @depends testFormInput
     * @return ElementInterface
     */
    public function testInputLabel(InputInterface $input)
    {
        $label = $input->getLabel();
        $this->assertInstanceOf(ElementInterface::class, $label);
        return $label;
    }

    /**
     * @param ElementInterface $label
     * @depends testInputLabel
     */
    public function testLabelValue(ElementInterface $label)
    {
        $this->assertEquals('Username or e-mail address', $label->getValue());
    }

    /**
     * @param InputInterface $input
     * @depends testFormInput
     */
    public function testValidators(InputInterface $input)
    {
        $validators = $input->getValidationChain();
        $this->assertInstanceOf(ValidationChainInterface::class, $validators);
    }

    /**
     * @param InputInterface $input
     * @depends testFormInput
     */
    public function testValidation(InputInterface $input)
    {
        $input->setValue('');
        $this->assertFalse($input->isValid());
        $this->assertContains(
            'You have to enter a username or email address to login',
            $input->getValidationChain()->getMessages()
        );
        $input->setValue('test');
        $this->assertTrue($input->isValid());
    }

    public function testNoValidationInput()
    {
        $this->form = new Form();
        AddElements::execute($this->form, ['id' => 'test', 'elements' => [
            'name' => [
                'type' => 'text'
            ]
        ]]);

        $this->assertNull($this->form->get('name')->getLabel());

    }

    /**
     * @param ElementInterface $label
     * @depends testInputLabel
     */
    public function testAttributes(ElementInterface $label)
    {
        $this->assertEquals('sr-only', $label->getAttribute('class'));
    }

    /**
     * @param InputInterface $input
     * @depends testFormInput
     */
    public function testCheckRequireAttribute(InputInterface $input)
    {
        $this->assertTrue($input->getAttributes()->containsKey('required'));
    }

    public function testNestedElements()
    {
        /** @var FieldSet $fieldSet */
        $fieldSet = $this->form->get('buttonGroup');
        $this->assertInstanceOf(FieldSet::class, $fieldSet);
        $this->assertEquals('Login', $fieldSet->get('submit')->getValue());
    }

    /**
     * @expectedException \Slick\Form\Exception\InvalidArgumentException
     */
    public function testUnknownClass()
    {
        $this->form = new Form();
        AddElements::execute($this->form, ['id' => 'test', 'elements' => [
            'name' => [
                'type' => '_text_unknown_'
            ]
        ]]);
    }

    /**
     * @expectedException \Slick\Form\Exception\InvalidArgumentException
     */
    public function testInvalidClass()
    {
        $this->form = new Form();
        AddElements::execute($this->form, ['id' => 'test', 'elements' => [
            'name' => [
                'type' => 'stdClass'
            ]
        ]]);
    }
}
