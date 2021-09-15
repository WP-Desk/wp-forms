<?php

namespace WPDesk\Forms\Field\Traits;

/**
 * Implementation of HTML attributes like id, name, action etc.
 *
 * @package WPDesk\Forms\Field\Traits
 */
trait HtmlAttributes {

	/** @var array{placeholder: string, name: string, id: string, class: string[], readonly: bool, multiple: bool, disabled: bool, required: bool, method: string, action: string} */
	protected $attributes = [
		'placeholder' => '',
		'name'        => '',
		'id'          => '',
		'class'       => [],
		'action'      => '',
		'method'      => 'POST',
		'readonly'    => false,
		'multiple'    => false,
		'disabled'    => false,
		'required'    => false,
	];

	/**
	 * Get list of all attributes except given.
	 *
	 * @param string[] $except
	 *
	 * @return array<string[]|string|bool>
	 */
	final public function get_attributes( array $except = [ 'name' ] ): array {
		return array_filter(
			$this->attributes,
			static function ( $key ) use ( $except ) {
				return ! in_array( $key, $except, true );
			},
			ARRAY_FILTER_USE_KEY
		);
	}

	/**
	 * @param string $name
	 * @param string[]|string|bool $value
	 *
	 * @return \WPDesk\Forms\Field|\WPDesk\Forms\Form
	 */
	final public function set_attribute( string $name, $value ) {
		$this->attributes[ $name ] = $value;

		return $this;
	}

	/**
	 * @return \WPDesk\Forms\Field|\WPDesk\Forms\Form
	 */
	final public function unset_attribute( string $name ) {
		unset( $this->attributes[ $name ] );

		return $this;
	}

	final public function is_attribute_set( string $name ): bool {
		return ! empty( $this->attributes[ $name ] );
	}

	final public function get_attribute( string $name, string $default = null ): string {
		if ( is_array( $this->attributes[ $name ] ) ) {
			// Be aware of coercing - if implode returns string(0) '', then return $default value.
			return implode( ' ', $this->attributes[ $name ] ) ?: $default ?? '';
		}
		return (string) $this->attributes[ $name ] ?? $default ?? '';
	}
}
