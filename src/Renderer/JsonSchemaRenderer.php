<?php

namespace WPDesk\Forms\Renderer;

use WPDesk\Forms\Field;
use WPDesk\Forms\FieldProvider;
use WPDesk\Forms\FieldRenderer;

class JsonSchemaRenderer implements FieldRenderer {

	/**
	 * @param array<string, mixed> $fields_data
	 * @return array{type: string, properties: array<string, array<string, mixed>>, required: string[]}
	 */
	public function render_fields( FieldProvider $provider, array $fields_data, string $name_prefix = '' ) {
		$properties = [];
		$required   = [];

		$fields = $provider->get_fields();
		usort(
			$fields,
			static function ( Field $a, Field $b ) {
				return $a->get_priority() <=> $b->get_priority();
			}
		);

		foreach ( $fields as $field ) {
			$name = $field->get_name();
			if ( '' === $name ) {
				continue;
			}

			$schema = [
				'type'         => $this->get_type( $field ),
				'title'        => $field->get_label(),
				'description'  => $field->get_description(),
				'default'      => $fields_data[ $name ] ?? $field->get_default_value(),
				'readOnly'     => $field->is_readonly(),
				'presentation' => [
					'position' => $field->get_priority(),
				],
			];

			if ( $field->has_placeholder() ) {
				$schema['examples'] = [ $field->get_placeholder() ];
			}

			if ( $field->get_type() !== $schema['type'] ) {
				$schema['format'] = $field->get_type();
			}

			$options = $field->get_possible_values();
			if ( ! empty( $options ) ) {
				$schema['enum'] = $options;
			}

			$schema = array_filter(
				$schema,
				static function ( $value ) {
					if ( is_array( $value ) ) {
						return ! empty( $value );
					}

					return $value !== null && $value !== '';
				}
			);

			$properties[ $name ] = $schema;

			if ( $field->is_required() ) {
				$required[] = $name;
			}
		}

		return [
			'type'       => 'object',
			'properties' => $properties,
			'required'   => $required,
		];
	}

	private function get_type( Field $field ): string {
		switch ( $field->get_type() ) {
			case 'checkbox':
				return 'boolean';
			case 'number':
				return 'number';
			default:
				return 'string';
		}
	}
}
