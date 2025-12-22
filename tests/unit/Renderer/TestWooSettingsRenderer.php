<?php

declare(strict_types=1);

namespace WPDesk\Forms\Tests\Renderer;

use PHPUnit\Framework\TestCase;
use WPDesk\Forms\Form\FormWithFields;
use WPDesk\Forms\Renderer\WooSettingsRenderer;
use WPDesk\Forms\Tests\Stubs\TestField;

class TestWooSettingsRenderer extends TestCase {

	public function test_exports_fields_to_woocommerce_format(): void {
		$field = ( new TestField() )
			->set_name( 'sample' )
			->set_label( 'Sample Field' )
			->set_description( 'Description' )
			->set_placeholder( 'Value' )
			->set_priority( 1 );

		$form = new FormWithFields( [ $field ] );
		$renderer = new WooSettingsRenderer();

		$result = $renderer->render_fields( $form, [] );

		$this->assertSame( 'sample', $result[0]['id'] );
		$this->assertSame( 'Sample Field', $result[0]['title'] );
		$this->assertSame( 'Description', $result[0]['desc'] );
	}
}
