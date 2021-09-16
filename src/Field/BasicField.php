<?php

namespace WPDesk\Forms\Field;

use WPDesk\Forms\Field;
use WPDesk\Forms\Sanitizer;
use WPDesk\Forms\Sanitizer\NoSanitize;
use WPDesk\Forms\Serializer;
use WPDesk\Forms\Validator;
use WPDesk\Forms\Validator\ChainValidator;
use WPDesk\Forms\Validator\RequiredValidator;

/**
 * Base class for fields. Is responsible for settings all required field values and provides standard implementation for
 * the field interface.
 *
 * @package WPDesk\Forms
 */
abstract class BasicField implements Field {
	use Field\Traits\HtmlAttributes;

	const DEFAULT_PRIORITY = 10;

	/** @var array{default_value: string, possible_values?: string[], sublabel?: string, priority: int, label: string, description: string, description_tip: string, data: array<string|int>, serializer: ?Serializer} */
	protected $meta = [
		'priority'          => self::DEFAULT_PRIORITY,
		'default_value'     => '',
		'label'             => '',
		'description'       => '',
		'description_tip'   => '',
		'data'              => [],
		'serializer'        => null,
	];

	public function should_override_form_template(): bool {
		return false;
	}

	public function get_type(): string {
		return 'text';
	}

	public function get_validator(): Validator {
		$chain = new ChainValidator();
		if ( $this->is_required() ) {
			$chain->attach( new RequiredValidator() );
		}

		return $chain;
	}

	public function get_sanitizer(): Sanitizer {
		return new NoSanitize();
	}

	public function get_serializer(): Serializer {
		return null;
	}

	final public function get_name(): string {
		return $this->attributes['name'];
	}

	final public function get_label(): string {
		return $this->meta['label'];
	}

	final public function set_label( string $value ): Field {
		$this->meta['label'] = $value;

		return $this;
	}

	final public function get_description_tip(): string {
		return $this->meta['description_tip'];
	}

	final public function has_description_tip(): bool {
		return ! empty( $this->meta['description_tip'] );
	}

	final public function get_description(): string {
		return $this->meta['description'];
	}

	final public function has_label(): bool {
		return ! empty( $this->meta['label'] );
	}

	final public function has_description(): bool {
		return ! empty( $this->meta['description'] );
	}

	final public function set_description( string $value ): Field {
		$this->meta['description'] = $value;

		return $this;
	}

	final public function set_description_tip( string $value ): Field {
		$this->meta['description_tip'] = $value;

		return $this;
	}

	final public function set_placeholder( string $value ): Field {
		$this->attributes['placeholder'] = $value;

		return $this;
	}

	final public function has_placeholder(): bool {
		return ! empty( $this->attributes['placeholder'] );
	}

	final public function get_placeholder(): string {
		return $this->attributes['placeholder'];
	}

	final public function set_name( string $name ): Field {
		$this->attributes['name'] = $name;

		return $this;
	}

	final public function get_meta_value( string $name ) {
		return $this->meta[ $name ];
	}

	final public function get_classes(): string {
		return implode( ' ', $this->attributes['class'] );
	}

	final public function has_classes(): bool {
		return ! empty( $this->attributes['class'] );
	}

	final public function has_data(): bool {
		return ! empty( $this->meta['data'] );
	}

	final public function get_data(): array {
		return $this->meta['data'];
	}

	final public function get_possible_values() {
		return ! empty( $this->meta['possible_values'] ) ? $this->meta['possible_values'] : [];
	}

	final public function get_id(): string {
		return $this->attributes['id'] ?? sanitize_title( $this->get_name() );
	}


	final public function is_multiple(): bool {
		return $this->attributes['multiple'];
	}

	final public function set_disabled(): Field {
		$this->attributes['disabled'] = true;

		return $this;
	}

	final public function is_disabled(): bool {
		return $this->attributes['disabled'];
	}

	final public function set_readonly(): Field {
		$this->attributes['readonly'] = true;

		return $this;
	}

	final public function is_readonly(): bool {
		return $this->attributes['readonly'];
	}

	final public function set_required(): Field {
		$this->attributes['required'] = true;

		return $this;
	}

	final public function add_class( string $class_name ): Field {
		$this->attributes['class'][ $class_name ] = $class_name;

		return $this;
	}

	final public function unset_class( string $class_name ): Field {
		unset( $this->attributes['class'][ $class_name ] );

		return $this;
	}

	final public function add_data( string $data_name, string $data_value ): Field {
		if ( empty( $this->meta['data'] ) ) {
			$this->meta['data'] = [];
		}
		$this->meta['data'][ $data_name ] = $data_value;

		return $this;
	}

	final public function unset_data( string $data_name ): Field {
		unset( $this->meta['data'][ $data_name ] );

		return $this;
	}

	final public function is_meta_value_set( string $name ): bool {
		return ! empty( $this->meta[ $name ] );
	}

	final public function is_class_set( string $name ): bool {
		return ! empty( $this->attributes['class'][ $name ] );
	}

	final public function get_default_value(): string {
		return $this->meta['default_value'];
	}

	final public function set_default_value( string $value ): Field {
		$this->meta['default_value'] = $value;

		return $this;
	}

	final public function is_required(): bool {
		return $this->attributes['required'];
	}

	final public function has_serializer(): bool {
		return ! empty( $this->meta['serializer'] );
	}

	final public function get_priority(): int {
		return $this->meta['priority'];
	}

	/**
	 * Fields are sorted by lowest priority value first, when getting FormWithFields
	 *
	 * @see FormWithFields::get_fields()
	 */
	final public function set_priority( int $priority ): Field {
		$this->meta['priority'] = $priority;

		return $this;
	}
}
