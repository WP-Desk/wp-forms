<?php

namespace Tests;

use WPDesk\Forms\AbstractForm;
use WPDesk\Forms\ConditionalFormInterface;
use WPDesk\Forms\FormsCollection;

class TestFormCollection extends \PHPUnit\Framework\TestCase
{

	private $anonymousFormConditionalTrue;
	private $anonymousFormConditionalFalse;

	protected function setUp(){

		// Create a new instance from the Abstract Class
		$this->anonymousFormConditionalTrue = new class extends AbstractForm implements ConditionalFormInterface{

			protected $form_id = 'test_form';

			protected function create_form_data() {
				return [ 'test' => true ];
			}

			public function is_active() {
				return true;
			}

		};

		// Create a new instance from the Abstract Class
		$this->anonymousFormConditionalFalse = new class extends AbstractForm implements ConditionalFormInterface{

			protected $form_id = 'test_form2';

			protected function create_form_data() {
				return [ 'test2' => true ];
			}

			public function is_active() {
				return false;
			}

		};


	}

	protected function getAnonymousFormConditionalTrue(){
		return clone $this->anonymousFormConditionalTrue;
	}

	protected function getAnonymousFormConditionalFalse(){
		return clone $this->anonymousFormConditionalFalse;
	}

	/**
	 * Test adding and checking single form.
	 */
	public function testIfFormExists()
	{
		$collection = new FormsCollection();
		$collection->add_form( $this->getAnonymousFormConditionalTrue() );

		$this->assertTrue( $collection->is_form_exists( 'test_form' ) );
	}

    /**
     * Test adding and checking multiple forms.
     */
    public function testIfFormsExists()
    {
    	$collection = new FormsCollection();
    	$collection->add_forms([
    		$this->getAnonymousFormConditionalTrue(),
		    $this->getAnonymousFormConditionalFalse(),
	    ]);

	    $this->assertTrue( $collection->is_form_exists( 'test_form' ) );
	    $this->assertTrue( $collection->is_form_exists( 'test_form2' ) );
    }

	/**
	 * Test adding and getting single form.
	 */
	public function testGettingExistingForm()
	{
		$collection = new FormsCollection();
		$collection->add_form( $this->getAnonymousFormConditionalTrue() );

		$this->assertInstanceOf(
			AbstractForm::class,
			$collection->get_form( 'test_form' )
		);
	}

	/**
	 * Test adding and getting not existing single form.
	 */
	public function testGettingNotExistingForm()
	{
		$collection = new FormsCollection();
		$collection->add_form( $this->getAnonymousFormConditionalTrue() );

		$this->expectException(\OutOfRangeException::class);
		$collection->get_form( '123456' );
	}

	/**
	 * Test returned data.
	 */
	public function testReturnedFormsData() {
		$collection = new FormsCollection();
		$collection->add_forms( [
			$this->getAnonymousFormConditionalTrue(),
			$this->getAnonymousFormConditionalFalse(),
		] );

		$this->assertSame( [ 'test' => true ], $collection->get_forms_data() );

		//test prefixed
		$this->assertSame( [ 'test_form_test' => true ], $collection->get_forms_data( true ) );

		//test updated array
		$form = $collection->get_form('test_form' );
		$form->update_form_data( [ 'test666' => true ] );

		$this->assertSame( [ 'test' => true, 'test666' => true ], $collection->get_forms_data() );
		//test

	}
}