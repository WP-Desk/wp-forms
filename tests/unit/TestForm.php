<?php

namespace Tests;

use WPDesk\Forms\AbstractForm;

class TestForm extends \PHPUnit\Framework\TestCase
{

	const FORM1_ID = 'test_form';
	const TEST_ARRAY = [ 'test' => true ];

	private $form;

	protected function setUp(){
		// Create a new instance from the Abstract Class
		$this->form = $this->getMockBuilder( AbstractForm::class )
		                   ->enableOriginalConstructor()
		                   ->setMethods(['get_form_id'])
		                   ->getMockForAbstractClass();
		$this->form->method( 'get_form_id' )->willReturn( self::FORM1_ID );
		$this->form->method( 'create_form_data' )->willReturn( self::TEST_ARRAY );
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
		$this->assertSame( self::TEST_ARRAY, $form->get_form_data());
	}

	/**
	 * Test updated form data.
	 */
	public function testUpdatedFormData()
	{
		$form = $this->getForm();
		$updateData = [ 'updated' => true ];

		$form->update_form_data( $updateData );
		$this->assertSame( array_merge( self::TEST_ARRAY, $updateData ), $form->get_form_data());
	}
}