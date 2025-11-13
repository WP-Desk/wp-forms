<?php

declare(strict_types=1);

namespace WPDesk\Forms\Tests\Form;

use PHPUnit\Framework\TestCase;
use WPDesk\Forms\Field\GroupField;
use WPDesk\Forms\Form\FormWithFields;
use WPDesk\Forms\Sanitizer;
use WPDesk\Forms\Tests\Stubs\TestField;
use WPDesk\Forms\Validator;

class TestFormWithFields extends TestCase {

	public function test_collects_validation_messages(): void {
		$field = ( new TestField() )->set_name( 'sample' );

		$field->add_validator(
			new class implements Validator {
				public function is_valid( $value ): bool {
					return $value === 'ok';
				}

				public function get_messages(): array {
					return [ 'value must equal ok' ];
				}
			}
		);

		$form = new FormWithFields( [ $field ] );
		$form->handle_request( [ 'sample' => 'nope' ] );

		$this->assertFalse( $form->is_valid() );
		$this->assertSame(
			[
				'sample' => [ 'value must equal ok' ],
			],
			$form->get_validation_messages()
		);
	}

	public function test_sanitizes_after_handle_request(): void {
		$field = ( new TestField() )->set_name( 'sample' );

		$field->add_sanitizer(
			new class implements Sanitizer {
				public function sanitize( $value ) {
					return strtoupper( (string) $value );
				}
			}
		);

		$form = new FormWithFields( [ $field ] );
		$form->handle_request( [ 'sample' => 'value' ] );

		$this->assertSame(
			[
				'sample' => 'VALUE',
			],
			$form->get_normalized_data()
		);
	}

	public function test_group_fields_are_processed(): void {
		$child = ( new TestField() )->set_name( 'child' );

		$group = ( new GroupField( [ $child ] ) );
		$group->set_label( 'Group' );

		$form = new FormWithFields( [ $group ] );
		$form->handle_request( [ 'child' => 'abc' ] );

		$this->assertSame( 'abc', $form->get_data()['child'] );
	}
}
