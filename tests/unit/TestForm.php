<?php

namespace Tests;

use WPDesk\Forms\AbstractForm;

class TestForm extends \PHPUnit\Framework\TestCase
{

	private $anonymousForm;

	protected function setUp(){

		// Create a new instance from the Abstract Class
		$this->anonymousForm = new class extends AbstractForm {

			protected $form_id = 'test_form';

			protected function create_form_data() {
				return [ 'test' => true ];
			}

		};
	}

	protected function getAnonymousForm(){
		return clone $this->anonymousForm;
	}

    /**
     * Test getting form id.
     */
    public function testFormId()
    {
    	$form = $this->getAnonymousForm();
	    $this->assertEquals('test_form', $form->get_form_id());
    }

	/**
	 * Test getting form data.
	 */
	public function testFormData()
	{
		$form = $this->getAnonymousForm();
		$this->assertSame( [ 'test' => true ], $form->get_form_data());
	}

	/**
	 * Test updated form data.
	 */
	public function testUpdatedFormData()
	{
		$form = $this->getAnonymousForm();
		$updateData = [ 'updated' => true ];

		$form->update_form_data( $updateData );
		$this->assertSame( [ 'test' => true, 'updated' => true ], $form->get_form_data());
	}
}