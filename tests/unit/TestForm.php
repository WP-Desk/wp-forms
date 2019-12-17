<?php

namespace Tests;

use WPDesk\Forms\AbstractForm;

class TestForm extends \PHPUnit\Framework\TestCase
{

	const FORM1_ID                = 'test_form';
	const FORM1_FORM_DATA         = [ 'test' => true ];
	const FORM1_UPDATED_FORM_DATA = [ 'test666' => true ];

	private $form;

	protected function setUp(){
		// Create a new instance from the Abstract Class
		$this->form = $this->getMockBuilder( AbstractForm::class )
		                   ->enableOriginalConstructor()
		                   ->setMethods(['get_form_id'])
		                   ->getMockForAbstractClass();
		$this->form->method( 'get_form_id' )->willReturn( self::FORM1_ID );
		$this->form->method( 'create_form_data' )->willReturn( self::FORM1_FORM_DATA );
	}

	protected function getForm(){
		return clone $this->form;
	}

    /**
     * Test getting form id.
     */
    public function testFormId()
    {
    	$form = $this->getForm();
	    $this->assertEquals(self::FORM1_ID, $form->get_form_id());
    }

	/**
	 * Test getting form data.
	 */
	public function testFormData()
	{
		$form = $this->getForm();
		$this->assertSame( self::FORM1_FORM_DATA, $form->get_form_data());
	}

	/**
	 * Test updated form data.
	 */
	public function testUpdatedFormData()
	{
		$form = $this->getForm();

		$form->update_form_data( self::FORM1_UPDATED_FORM_DATA );
		$this->assertSame( array_merge( self::FORM1_FORM_DATA, self::FORM1_UPDATED_FORM_DATA ), $form->get_form_data());
	}
}