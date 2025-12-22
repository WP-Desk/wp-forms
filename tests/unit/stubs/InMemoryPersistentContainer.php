<?php

declare(strict_types=1);

namespace WPDesk\Forms\Tests\Stubs;

use WPDesk\Persistence\ElementNotExistsException;
use WPDesk\Persistence\PersistentContainer;

class InMemoryPersistentContainer implements PersistentContainer {

	/** @var array<string, mixed> */
	private $data = [];

	public function set( string $id, $value ) {
		$this->data[ $id ] = $value;
	}

	public function delete( string $id ) {
		unset( $this->data[ $id ] );
	}

	public function has( $id ): bool {
		return array_key_exists( $id, $this->data );
	}

	public function get_fallback( string $id, $fallback = null ) {
		return $this->has( $id ) ? $this->data[ $id ] : $fallback;
	}

	public function get( $id ) {
		if ( ! $this->has( $id ) ) {
			throw new ElementNotExistsException( sprintf( 'Key %s not found.', $id ) );
		}

		return $this->data[ $id ];
	}

	public function all(): array {
		return $this->data;
	}
}
