<?php

namespace WPDesk\Forms\Field;

use WPDesk\Forms\Field;
use WPDesk\Forms\Sanitizer;
use WPDesk\Forms\Sanitizer\NoSanitize;
use WPDesk\Forms\Serializer;
use WPDesk\Forms\Serializer\NoSerialize;
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

	/** @var array<string,int,bool> */
	protected $meta;

	/** @var string */
	protected $default_value;

	public function __construct() {
		$this->meta['class']    = [];
		$this->meta['priority'] = self::DEFAULT_PRIORITY;
	}

	public function get_label(): string {
		return $this->meta['label'];
	}

	public function set_label( string $value ): Field {
		$this->meta['label'] = $value;

		return $this;
	}

	public function get_description_tip(): string {
		return $this->meta['description_tip'];
	}

	public function has_description_tip(): bool {
		return isset( $this->meta['description_tip'] );
	}

	public function should_override_form_template(): bool {
		return $this->attributes['overrite_template'] ?? false;
	}

	public function get_description(): string {
		return $this->meta['description'];
	}

	public function has_label(): bool {
		return isset( $this->meta['label'] );
	}

	public function has_description(): bool {
		return isset( $this->meta['description'] );
	}

	public function set_description( string $value ): Field {
		$this->meta['description'] = $value;

		return $this;
	}

	public function set_description_tip( string $value ): Field {
		$this->meta['description_tip'] = $value;

		return $this;
	}

	public function get_type(): string {
		return $this->attributes['type'];
	}

	public function set_placeholder( string $value ): Field {
		$this->meta['placeholder'] = $value;

		return $this;
	}

	public function has_placeholder(): bool {
		return isset( $this->meta['placeholder'] );
	}

	public function get_placeholder(): string {
		return $this->meta['placeholder'];
	}

	public function set_name( string $name ): Field {
		$this->attributes['name'] = $name;

		return $this;
	}

	public function get_meta_value( string $name ): string {
		return $this->meta[ $name ];
	}

	public function get_classes(): string {
		return implode( ' ', $this->meta['class'] );
	}

	public function has_classes(): bool {
		return ! empty( $this->meta['class'] );
	}

	public function has_data(): bool {
		return ! empty( $this->meta['data'] );
	}

	public function get_data(): array {
		return $this->meta['data'] ?: [];
	}

	public function get_possible_values() {
		return isset( $this->meta['possible_values'] ) ? $this->meta['possible_values'] : [];
	}

	public function get_id(): string {
		return $this->attributes['id'] ?? sanitize_title( $this->get_name() );
	}

	public function get_name(): string {
		return $this->attributes['name'];
	}

	public function is_multiple(): bool {
		return $this->attributes['multiple'] ?? false;
	}

	public function set_disabled(): Field {
		$this->attributes['disabled'] = true;

		return $this;
	}

	public function is_disabled(): bool {
		return $this->attributes['disabled'] ?? false;
	}

	public function set_readonly(): Field {
		$this->attributes['readonly'] = true;

		return $this;
	}

	public function is_readonly(): bool {
		return $this->attributes['readonly'] ?? false;
	}

	public function set_required(): Field {
		$this->meta['required'] = true;

		return $this;
	}

	public function add_class( string $class_name ): Field {
		$this->meta['class'][ $class_name ] = $class_name;

		return $this;
	}

	public function unset_class( string $class_name ): Field {
		unset( $this->meta['class'][ $class_name ] );

		return $this;
	}

	public function add_data( string $data_name, string $data_value ): Field {
		if ( ! isset( $this->meta['data'] ) ) {
			$this->meta['data'] = [];
		}
		$this->meta['data'][ $data_name ] = $data_value;

		return $this;
	}

	public function unset_data( string $data_name ): Field {
		unset( $this->meta['data'][ $data_name ] );

		return $this;
	}

	public function is_meta_value_set( string $name ): bool {
		return isset( $this->meta[ $name ] );
	}

	public function is_class_set( string $name ): bool {
		return isset( $this->meta['class'][ $name ] );
	}

	/** @return mixed */
	public function get_default_value() {
		return $this->default_value;
	}

	/** @param mixed $value */
	public function set_default_value( $value ): Field {
		$this->default_value = $value;

		return $this;
	}

	public function get_validator(): Validator {
		$chain = new ChainValidator();
		if ( $this->is_required() ) {
			$chain->attach( new RequiredValidator() );
		}

		return $chain;
	}

	public function is_required(): bool {
		return $this->meta['required'] ?? false;
	}

	public function get_sanitizer(): Sanitizer {
		return new NoSanitize();
	}

	public function get_serializer(): Serializer {
		if ( isset( $this->meta['serializer'] ) && $this->meta['serializer'] instanceof Serializer ) {
			return $this->meta['serializer'];
		}

		return new NoSerialize();
	}

	public function set_serializer( Serializer $serializer ): Field {
		$this->meta['serializer'] = $serializer;

		return $this;
	}

	public function get_priority(): int {
		return $this->meta['priority'];
	}

	/**
	 * Fields are sorted by lowest priority value first, when getting FormWithFields
	 *
	 * @see FormWithFields::get_fields()
	 */
	public function set_priority( int $priority ): Field {
		$this->meta['priority'] = $priority;

		return $this;
	}
}
