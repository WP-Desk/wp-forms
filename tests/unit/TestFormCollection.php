<?php

namespace Tests;

use WPDesk\Forms\AbstractForm;
use WPDesk\Forms\FormsCollection;

class TestFormCollection extends \PHPUnit\Framework\TestCase
{

	const FORM1_ID = 'test_form';
	const FORM2_ID = 'test_form2';

	const TEST_ARRAY1 = [ 'test' => true ];
	const TEST_ARRAY2 = [ 'test2' => 'potato' ];

	private $formConditionalTrue;
	private $formConditionalFalse;

	protected function setUp(){
		$this->formConditionalTrue = $this->getMockBuilder( AbstractForm::class )
		                                  ->enableOriginalConstructor()
		                                  ->setMethods( [ 'get_form_id', 'is_active' ] )
		                                  ->getMockForAbstractClass();
		$this->formConditionalTrue->method( 'get_form_id' )->willReturn( self::FORM1_ID );
		$this->formConditionalTrue->method( 'is_active' )->willReturn( true );
		$this->formConditionalTrue->method( 'create_form_data' )->willReturn( self::TEST_ARRAY1 );

		$this->formConditionalFalse = $this->getMockBuilder( AbstractForm::class )
		                                   ->enableOriginalConstructor()
		                                   ->setMethods( [ 'get_form_id', 'is_active' ] )
		                                   ->getMockForAbstractClass();
		$this->formConditionalFalse->method( 'get_form_id' )->willReturn( self::FORM2_ID );
		$this->formConditionalFalse->method( 'is_active' )->willReturn( false );
		$this->formConditionalFalse->method( 'create_form_data' )->willReturn( self::TEST_ARRAY2 );
	}

	protected function getFormConditionalTrue(){
		return clone $this->formConditionalTrue;
	}

	protected function getFormConditionalFalse(){
		return clone $this->formConditionalFalse;
	}

	/**
	 * Test adding and checking single form.
	 */
	public function testIfFormExists()
	{
		$collection = new FormsCollection();
		$collection->add_form( $this->getFormConditionalTrue() );

		$this->assertTrue( $collection->is_form_exists( self::FORM1_ID ) );
	}

    /**
     * Test adding and checking multiple forms.
     */
    public function testIfFormsExists()
    {
    	$collection = new FormsCollection();
    	$collection->add_forms([
    		$this->getFormConditionalTrue(),
		    $this->getFormConditionalFalse(),
	    ]);

	    $this->assertTrue( $collection->is_form_exists( self::FORM1_ID ) );
	    $this->assertTrue( $collection->is_form_exists( self::FORM2_ID ) );
    }

	/**
	 * Test getting single form. AbstractForm object is expected
	 */
	public function testGettingExistingForm()
	{
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
	public function testGettingNotExistingForm()
	{
		$collection = new FormsCollection();
		$collection->add_form( $this->getFormConditionalTrue() );

		$this->expectException(\OutOfRangeException::class);
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

		$this->assertSame( self::TEST_ARRAY1, $collection->get_forms_data() );
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

		$this->assertSame( [ 'test_form_test' => true ], $collection->get_forms_data( true ) );


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

		$test_array = [ 'test666' => true ];
		$form       = $collection->get_form( self::FORM1_ID );
		$form->update_form_data( $test_array );
		$this->assertSame( array_merge( self::TEST_ARRAY1, $test_array ), $collection->get_forms_data() );

	}

}