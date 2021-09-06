<?php

namespace WPDesk\Forms\Field\Traits;

/**
 * Implementation of HTML attributes like id, name, action etc.
 *
 * @package WPDesk\Forms\Field\Traits
 */
trait HtmlAttributes {

	/** @var string[] */
	protected $attributes;

	/**
	 * Get list of all attributes except given.
	 *
	 * @param string[] $except
	 *
	 * @return string[]
	 */
	public function get_attributes( array $except = [ 'name', 'type' ] ): array {
		return array_filter(
			$this->attributes,
			static function ( $value, $key ) use ( $except ) {
				return ! in_array( $key, $except, true );
			},
			ARRAY_FILTER_USE_BOTH
		);
	}

	public function set_attribute( string $name, string $value ): self {
		$this->attributes[ $name ] = $value;

		return $this;
	}

	public function unset_attribute( string $name ): self {
		unset( $this->attributes[ $name ] );

		return $this;
	}

	public function is_attribute_set( string $name ): bool {
		return isset( $this->attributes[ $name ] );
	}

	/**
	 * @param string  $name
	 * @param ?string $default
	 *
	 * @return string
	 */
	public function get_attribute( string $name, $default = null ): string {
		return $this->attributes[ $name ] ?? $default;
	}
}
