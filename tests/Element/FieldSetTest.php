<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form\Element;

use PHPUnit_Framework_TestCase as TestCase;
use Slick\Form\Element\FieldSet;
use Slick\Form\Input\Text;

/**
 * Field Set test case
 *
 * @package Slick\Tests\Form\Element
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class FieldSetTest extends TestCase
{

    /**
     * @var FieldSet
     */
    protected $fieldSet;

    /**
     * Set SUT field set object
     */
    protected function setUp()
    {
        parent::setUp();
        $this->fieldSet = new FieldSet();
    }

    /**
     * Clear the SUT after the test
     */
    protected function tearDown()
    {
        $this->fieldSet = null;
        parent::tearDown();
    }

    /**
     * Should set and retrieve name without adding it to the attributes
     * @test
     */
    public function setElementName()
    {
        $name = 'test';
        $this->assertSame($this->fieldSet, $this->fieldSet->setName($name));
        $attributes = $this->fieldSet->getAttributes();
        $this->assertFalse($attributes->containsKey('name'));
        $this->assertEquals($name, $this->fieldSet->getName());
    }

    /**
     * Should set and retrieve value without adding it to the attributes
     * @test
     */
    public function setElementValue()
    {
        $value = 'test';
        $this->assertSame($this->fieldSet, $this->fieldSet->setValue($value));
        $attributes = $this->fieldSet->getAttributes();
        $this->assertFalse($attributes->containsKey('value'));
        $this->assertEquals($value, $this->fieldSet->getValue());
    }

    /**
     * Should use the input name to add key to field set data
     * @test
     */
    public function addInput()
    {
        $text = new Text();
        $text->setName('address')
            ->setLabel('Address');
        $this->fieldSet[] = $text;
        $this->assertSame($text, $this->fieldSet->get('address'));
    }

    /**
     * Should iterate over all elements and set the value to the ones
     * that names matched the provided array keys.
     * @test
     */
    public function setValues()
    {
        $text = new Text();
        $text->setName('address')
            ->setLabel('Address')
            ->setValue('none');
        $group = (new FieldSet())->add($text);

        $this->fieldSet
            ->add((new Text)->setName('name')->setValue(''))
            ->add($group)
            ->setValues(['foo' => 'bar', 'address' => 'test', 'name' => 'other']);
        $this->assertEquals('test', $text->getValue());
        $this->assertEquals('other', $this->fieldSet->get('name')->getValue());
    }

    /**
     * Iterates over all elements to to check its validity
     * @test
     */
    public function validInputs()
    {
        $address = (new Text())->setName('address');
        $name = (new Text())->setName('name');
        $this->assertTrue(
            $this->fieldSet
                ->add($address)
                ->add($name)
                ->isValid()
        );
    }

    /**
     * Iterates over all elements to to check its validity
     * @test
     */
    public function validInvalidInputs()
    {
        $address = (new Text())->setName('address');
        $name = (new Text())
            ->setName('name')
            ->addValidator('notEmpty');

        $this->assertFalse(
            $this->fieldSet
                ->add($address)
                ->add($name)
                ->isValid()
        );
    }

    public function testOutput()
    {
        $input = new Text();
        $input->setLabel('Name')
            ->setName('name')
            ->setValue('Jon Doe');
        $input->setAttribute('class', 'my-class')
            ->setAttribute('required');
        $this->fieldSet->add($input)
            ->setValue('Test');
        $expects = <<<EOS
<fieldset >
    <legend>Test</legend>
    <div class="form-group">
    <label for="input-name" class="control-label">Name</label>
    <input type="text" id="input-name" name="name" value="Jon Doe" class="my-class form-control" required>
</div>
</fieldset>
EOS;
        $this->assertEquals($expects, $this->fieldSet->render());

    }
}
