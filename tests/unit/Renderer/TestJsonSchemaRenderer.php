<?php

declare(strict_types=1);

namespace WPDesk\Forms\Tests\Renderer;

use PHPUnit\Framework\TestCase;
use WPDesk\Forms\Form\FormWithFields;
use WPDesk\Forms\Renderer\JsonSchemaRenderer;
use WPDesk\Forms\Tests\Stubs\TestField;

class TestJsonSchemaRenderer extends TestCase {

	public function test_generates_schema_with_required_fields(): void {
		$field = ( new TestField() )
			->set_name( 'email' )
			->set_label( 'Email' )
			->set_description( 'Customer email' )
			->set_placeholder( 'test@example.com' )
			->set_priority( 1 )
			->set_required();

		$form = new FormWithFields( [ $field ] );

		$renderer = new JsonSchemaRenderer();
		$schema   = $renderer->render_fields( $form, [] );

		$this->assertSame( [ 'email' ], $schema['required'] );
		$this->assertArrayHasKey( 'email', $schema['properties'] );
		$this->assertSame( 'Email', $schema['properties']['email']['title'] );
	}
}
