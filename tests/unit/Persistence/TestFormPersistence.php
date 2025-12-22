<?php

declare(strict_types=1);

namespace WPDesk\Forms\Tests\Persistence;

use PHPUnit\Framework\TestCase;
use WPDesk\Forms\Form\FormWithFields;
use WPDesk\Forms\Persistence\FormPersistence;
use WPDesk\Forms\Serializer;
use WPDesk\Forms\Tests\Stubs\InMemoryPersistentContainer;
use WPDesk\Forms\Tests\Stubs\TestField;
use WPDesk\Forms\Tests\Stubs\TestSerializableField;

class TestFormPersistence extends TestCase {

	public function test_save_and_load_form_data(): void {
		$field = ( new TestField() )
			->set_name( 'sample' )
			->set_default_value( 'default' );

		$form = new FormWithFields( [ $field ] );
		$form->handle_request( [ 'sample' => 'value' ] );

		$container    = new InMemoryPersistentContainer();
		$persistence  = FormPersistence::for_form( $form, $container );
		$persistence->save_form( $form );

		$loaded_form = new FormWithFields( [ $field ] );
		FormPersistence::for_form( $loaded_form, $container )->hydrate_form( $loaded_form );

		$this->assertSame( 'value', $loaded_form->get_data()['sample'] );
	}

	public function test_serializer_is_used_during_save_and_load(): void {
		$serializer = new class implements Serializer {
			public function serialize( $value ): string {
				return json_encode( $value );
			}

			public function unserialize( string $value ) {
				return json_decode( $value, true );
			}
		};

		$field = ( new TestSerializableField( $serializer ) )
			->set_name( 'list' )
			->set_default_value( '' );

		$form = new FormWithFields( [ $field ] );
		$form->handle_request( [ 'list' => 'original' ] );

		$container   = new InMemoryPersistentContainer();
		$persistence = FormPersistence::for_form( $form, $container );
		$persistence->save_form( $form );

		$new_form = new FormWithFields( [ $field ] );
		FormPersistence::for_form( $new_form, $container )->hydrate_form( $new_form );

		$this->assertSame( 'original', $new_form->get_data()['list'] );
	}
}
