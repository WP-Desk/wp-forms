<?php

declare(strict_types=1);

namespace WPDesk\Forms\Tests\Form;

use PHPUnit\Framework\TestCase;
use WPDesk\Forms\Field\TabField;
use WPDesk\Forms\Form\TabbedForm;
use WPDesk\Forms\Tests\Stubs\TestField;
use WPDesk\View\Renderer\Renderer;
use WPDesk\View\Resolver\Resolver;

class TestTabbedForm extends TestCase {

	public function test_active_tab_defaults_to_first(): void {
		$form = new TabbedForm( $this->tabs() );

		$this->assertSame( 'general', $form->get_active_tab_slug() );
		$this->assertSame(
			[
				'general'  => 'General',
				'advanced' => 'Advanced',
			],
			$form->get_tab_labels()
		);
	}

	public function test_active_tab_data_only_contains_visible_tab_fields(): void {
		$form = new TabbedForm( $this->tabs() );
		$form->set_active_tab( 'advanced' );
		$form->handle_request(
			[
				'general_field'  => 'foo',
				'advanced_field' => 'bar',
			]
		);

		$this->assertSame(
			[ 'advanced_field' => 'bar' ],
			$form->get_active_tab_data()
		);
	}

	public function test_render_fields_uses_active_tab_template(): void {
		$form = new TabbedForm( $this->tabs(), 'form', 'advanced' );

		$renderer = new class implements Renderer {
			public array $templates = [];

			public function set_resolver( Resolver $resolver ) {}

			public function render( $template, array $params = null ) {
				$this->templates[] = $template;
				return $template;
			}

			public function output_render( $template, array $params = null ) {
			}
		};

		$form->render_fields( $renderer );

		$this->assertSame( [ 'tab' ], $renderer->templates );
	}

	/**
	 * @return TabField[]
	 */
	private function tabs(): array {
		$general_field = ( new TestField() )
			->set_name( 'general_field' )
			->set_label( 'General Field' );

		$general = ( new TabField( [ $general_field ] ) )
			->set_label( 'General' )
			->set_tab_id( 'general' );

		$advanced_field = ( new TestField() )
			->set_name( 'advanced_field' )
			->set_label( 'Advanced Field' );

		$advanced = ( new TabField( [ $advanced_field ] ) )
			->set_label( 'Advanced' )
			->set_tab_id( 'advanced' );

		return [ $general, $advanced ];
	}
}
