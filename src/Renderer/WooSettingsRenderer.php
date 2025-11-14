<?php

namespace WPDesk\Forms\Renderer;

use WPDesk\Forms\Field;
use WPDesk\Forms\FieldProvider;
use WPDesk\Forms\FieldRenderer;

class WooSettingsRenderer implements FieldRenderer {

	/**
	 * @param array<string, mixed> $fields_data
	 * @return array<int, array<string, mixed>>
	 */
	public function render_fields( FieldProvider $provider, array $fields_data, string $name_prefix = '' ) {
		$rendered = [];
		$fields   = $provider->get_fields();

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

			$item = [
				'id'          => $name,
				'title'       => $field->get_label(),
				'desc'        => $field->get_description(),
				'type'        => $field->get_type(),
				'default'     => $fields_data[ $name ] ?? $field->get_default_value(),
				'desc_tip'    => $field->has_description_tip() ? $field->get_description_tip() : '',
				'css'         => $field->has_classes() ? implode( ' ', explode( ' ', $field->get_classes() ) ) : '',
				'placeholder' => $field->has_placeholder() ? $field->get_placeholder() : '',
			];

			$options = $field->get_possible_values();
			if ( ! empty( $options ) ) {
				$item['options'] = $options;
			}

			$rendered[] = array_filter(
				$item,
				static function ( $value ) {
					return $value !== null && $value !== '';
				}
			);
		}

		return $rendered;
	}
}
