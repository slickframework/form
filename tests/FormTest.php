<?php

/**
 * This file is part of slick/form package
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Slick\Tests\Form;

use PHPUnit_Framework_TestCase as TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Psr\Http\Message\ServerRequestInterface;
use Slick\Form\Element\Button;
use Slick\Form\Element\FieldSet;
use Slick\Form\Form;
use Slick\Form\Input\File;
use Slick\Form\Input\Text;
use Slick\Http\PhpEnvironment\Request;

/**
 * HTML Form test case
 *
 * @package Slick\Tests\Form
 * @author  Filipe Silva <silvam.filipe@gmail.com>
 */
class FormTest extends TestCase
{

    /**
     * @var Form|MockObject
     */
    protected $form;

    /**
     * Sets the SUT form object
     */
    protected function setUp()
    {
        parent::setUp();
        $class = Form::class;
        $this->form = $this->getMockBuilder($class)
            ->setMethods(['setValues'])
            ->getMock();
    }

    protected function tearDown()
    {
        $this->form = null;
        parent::tearDown();
    }

    /**
     * Should create a form with action and method attributes defined
     * @test
     */
    public function defaultAttributes()
    {
        $this->assertEquals('', $this->form->getAttribute('action'));
        $this->assertEquals('post', $this->form->getAttribute('method'));
    }

    /**
     * Should call FieldSet::setValues() to populate all data
     * @test
     */
    public function setData()
    {
        $data = ['foo' => 'bar'];
        $this->form->expects($this->once())
            ->method('setValues')
            ->with($data)
            ->willReturn($this->form);
        $this->assertSame($this->form, $this->form->setData($data));
    }

    /**
     * Should set the request and return a self instance
     * @test
     */
    public function setRequest()
    {
        /** @var ServerRequestInterface $request */
        $request = $this->getMock(ServerRequestInterface::class);
        $this->assertSame($this->form, $this->form->setRequest($request));
    }

    /**
     * Should recursively get the names of the input elements
     * @test
     */
    public function getData()
    {
        $text = (new Text())->setName('baz')->setValue('bum');
        $group = (new FieldSet())->add($text);
        $this->form
            ->add((new Text())->setName('foo')->setValue('bar'))
            ->add($group)
            ->add(new Button());
        $this->assertEquals(
            ['foo' => 'bar', 'baz' => 'bum'],
            $this->form->getData()
        );
    }

    public function testOutput()
    {
        $form = new Form();
        $button = new Button();
        $button->setName('test')
            ->setValue('Test');
        $form->add($button);
        $expected = <<<EOHTML
<form action="" method="post">
    <button type="button">Test</button>
</form>
EOHTML;
        $this->assertEquals($expected, $form->render());

    }

    public function testMultipartWithFile()
    {
        $input = new File();
        $input->setName('test');
        $this->form->add($input);
        $this->assertEquals('multipart/form-data', $this->form->getAttribute('enctype'));
    }

    /**
     * Should create a new ServerRequest object if none is given yet
     * @test
     */
    public function getRequest()
    {
        $request = $this->form->getRequest();
        $this->assertInstanceOf(Request::class, $request);
    }

    /**
     * Should populate the form values if it was submitted
     * @test
     */
    public function populateValuesFromRequest()
    {
        $formId = 'test-form';
        $request = $this->getRequestMock();
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('POST');

        $request->expects($this->atLeast(2))
            ->method('getParsedBody')
            ->willReturn(['form-id' => $formId, 'foo' => 'bar']);

        $request->expects($this->once())
            ->method('isPost')
            ->willReturn('true');

        $request->expects($this->once())
            ->method('getUploadedFiles')
            ->willReturn(['bar' => (object)[]]);

        $this->form->setId($formId);
        $this->form->setRequest($request);

        $this->form->expects($this->once())
            ->method('setValues')
            ->with(
                [
                    'form-id' => $formId,
                    'foo' => 'bar',
                    'bar' => (object)[]
                ]
            );

        $this->assertTrue($this->form->wasSubmitted());
    }

    /**
     * Should return true if the method of request is equal to the method
     * of the form and the form-id parameter (post/get) should match.
     * @test
     */
    public function wasSubmitted()
    {
        $formId = 'test-form';
        $request = $this->getRequestMock();
        $request->expects($this->once())
            ->method('getMethod')
            ->willReturn('GET');
        $request->expects($this->once())
            ->method('getQuery')
            ->with('form-id')
            ->willReturn(false);
        $this->form->setId($formId);
        $this->form->setRequest($request);
        $this->assertFalse($this->form->wasSubmitted());

    }

    /**
     * @return MockObject|ServerRequestInterface
     */
    public function getRequestMock()
    {
        $class = Request::class;
        $methods = [
            'getMethod', 'isPost', 'getParsedBody',
            'getUploadedFiles', 'getQuery'
        ];
        /** @var ServerRequestInterface|MockObject $request */
        $request = $this->getMockBuilder($class)
            ->setMethods($methods)
            ->getMock();
        return $request;
    }
}
