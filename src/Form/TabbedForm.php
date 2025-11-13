<?php

namespace WPDesk\Forms\Form;

use WPDesk\Forms\Field\TabField;
use WPDesk\View\Renderer\Renderer;

/**
 * Form that understands tabs and renders only the active one while still validating all fields.
 */
class TabbedForm extends FormWithFields {

	/** @var TabField[] */
	private $tabs = [];

	/** @var string */
	private $active_tab_id = '';

	/**
	 * @param TabField[] $tabs
	 */
	public function __construct( array $tabs, string $form_id = 'form', ?string $active_tab = null ) {
		parent::__construct( $tabs, $form_id );

		foreach ( $tabs as $index => $tab ) {
			if ( ! $tab instanceof TabField ) {
				continue;
			}

			if ( '' === $tab->get_tab_id() ) {
				$tab->set_tab_id( $this->generate_tab_id( $tab, $index ) );
			}

			$this->tabs[ $tab->get_tab_id() ] = $tab;
		}

		$this->active_tab_id = $this->resolve_active_tab( $active_tab );
	}

	public function set_active_tab( string $tab_id ): self {
		$this->active_tab_id = $this->resolve_active_tab( $tab_id );

		return $this;
	}

	public function get_active_tab_slug(): string {
		return $this->active_tab_id;
	}

	/**
	 * @return TabField[]
	 */
	public function get_tabs(): array {
		return $this->tabs;
	}

	public function get_tab_labels(): array {
		$labels = [];
		foreach ( $this->tabs as $tab ) {
			$labels[ $tab->get_tab_id() ] = $tab->get_label();
		}

		return $labels;
	}

	public function get_active_tab(): ?TabField {
		return $this->tabs[ $this->active_tab_id ] ?? null;
	}

	public function get_active_tab_data(): array {
		$active = $this->get_active_tab();
		if ( ! $active ) {
			return [];
		}

		$data = [];
		foreach ( $active->get_fields() as $field ) {
			$name = $field->get_name();
			if ( '' === $name ) {
				continue;
			}
			$data[ $name ] = $this->get_data()[ $name ] ?? $field->get_default_value();
		}

		return $data;
	}

	public function render_fields( Renderer $renderer ): string {
		$active = $this->get_active_tab();
		if ( ! $active ) {
			return parent::render_fields( $renderer );
		}

		$fields_data = $this->get_data();

		return $renderer->render(
			$active->get_template_name(),
			[
				'field'         => $active,
				'renderer'      => $renderer,
				'name_prefix'   => $this->get_form_id(),
				'value'         => $fields_data,
				'template_name' => $active->get_template_name(),
			]
		);
	}

	private function generate_tab_id( TabField $tab, int $index ): string {
		$name = $tab->get_name();
		if ( '' !== $name ) {
			return $name;
		}

		return 'tab-' . $index;
	}

	private function resolve_active_tab( ?string $preferred ): string {
		if ( $preferred && isset( $this->tabs[ $preferred ] ) ) {
			return $preferred;
		}

		if ( ! empty( $this->tabs ) ) {
			return array_key_first( $this->tabs );
		}

		return '';
	}
}
