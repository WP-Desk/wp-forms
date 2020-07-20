<?php

namespace Tests;

use WPDesk\Forms\Form\AbstractForm;
use WPDesk\Forms\Form\FormsCollection;

class TestFormCollection extends \PHPUnit\Framework\TestCase {

	const FORM1_ID = 'test_form';
	const FORM2_ID = 'test_form2';

	const FORM1_FORM_DATA = [ 'test' => true ];
	const FORM2_FORM_DATA = [ 'test2' => 'potato' ];

	const FORM1_PREFIXED_FORM_DATA = [ 'test_form_test' => true ];
	const FORM1_UPDATED_FORM_DATA  = [ 'test666' => true ];


	private $formConditionalTrue;
	private $formConditionalFalse;

	protected function setUp() {
		$this->formConditionalTrue = $this->getMockBuilder( AbstractForm::class )
		                                  ->enableOriginalConstructor()
		                                  ->setMethods( [ 'get_form_id', 'is_active' ] )
		                                  ->getMockForAbstractClass();
		$this->formConditionalTrue->method( 'get_form_id' )->willReturn( self::FORM1_ID );
		$this->formConditionalTrue->method( 'is_active' )->willReturn( true );
		$this->formConditionalTrue->method( 'create_form_data' )->willReturn( self::FORM1_FORM_DATA );

		$this->formConditionalFalse = $this->getMockBuilder( AbstractForm::class )
		                                   ->enableOriginalConstructor()
		                                   ->setMethods( [ 'get_form_id', 'is_active' ] )
		                                   ->getMockForAbstractClass();
		$this->formConditionalFalse->method( 'get_form_id' )->willReturn( self::FORM2_ID );
		$this->formConditionalFalse->method( 'is_active' )->willReturn( false );
		$this->formConditionalFalse->method( 'create_form_data' )->willReturn( self::FORM2_FORM_DATA );
	}

	protected function getFormConditionalTrue() {
		return clone $this->formConditionalTrue;
	}

	protected function getFormConditionalFalse() {
		return clone $this->formConditionalFalse;
	}

	/**
	 * Test adding and checking single form.
	 */
	public function testIfFormExists() {
		$collection = new FormsCollection();
		$collection->add_form( $this->getFormConditionalTrue() );

		$this->assertTrue( $collection->is_form_exists( self::FORM1_ID ) );
	}

	/**
	 * Test adding and checking multiple forms.
	 */
	public function testIfFormsExists() {
		$collection = new FormsCollection();
		$collection->add_forms( [
			$this->getFormConditionalTrue(),
			$this->getFormConditionalFalse(),
		] );

		$this->assertTrue( $collection->is_form_exists( self::FORM1_ID ) );
		$this->assertTrue( $collection->is_form_exists( self::FORM2_ID ) );
	}

	/**
	 * Test getting single form. AbstractForm object is expected
	 */
	public function testGettingExistingForm() {
		$collection = new FormsCollection();
		$collection->add_form( $this->getFormConditionalTrue() );

		$this->assertInstanceOf(
			AbstractForm::class,
			$collection->get_form( self::FORM1_ID )
		);
	}

	/**
	 * Test getting not existing single form.
	 */
	public function testGettingNotExistingForm() {
		$collection = new FormsCollection();
		$collection->add_form( $this->getFormConditionalTrue() );

		$this->expectException( \OutOfRangeException::class );
		$collection->get_form( '123456' );
	}

	/**
	 * Test returned data.
	 */
	public function testReturnedFormsData() {
		$collection = new FormsCollection();
		$collection->add_forms( [
			$this->getFormConditionalTrue(),
			$this->getFormConditionalFalse(),
		] );

		$this->assertSame( self::FORM1_FORM_DATA, $collection->get_forms_data() );
	}

	/**
	 * Test returned prefixed data.
	 */
	public function testReturnedPrefixedFormsData() {
		$collection = new FormsCollection();
		$collection->add_forms( [
			$this->getFormConditionalTrue(),
			$this->getFormConditionalFalse(),
		] );

		$this->assertSame( self::FORM1_PREFIXED_FORM_DATA, $collection->get_forms_data( true ) );


	}

	/**
	 * Test returned updated data.
	 */
	public function testReturnedUpdatedFormsData() {
		$collection = new FormsCollection();
		$collection->add_forms( [
			$this->getFormConditionalTrue(),
			$this->getFormConditionalFalse(),
		] );

		$form = $collection->get_form( self::FORM1_ID );
		$form->update_form_data( self::FORM1_UPDATED_FORM_DATA );
		$this->assertSame( array_merge( self::FORM1_FORM_DATA, self::FORM1_UPDATED_FORM_DATA ), $collection->get_forms_data() );

	}

}