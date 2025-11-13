<?php

namespace WPDesk\Forms\Persistence;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ArrayContainer implements ContainerInterface {

	/** @var array<string, mixed> */
	private $data = [];

	public function __construct( array $data = [] ) {
		$this->data = $data;
	}

	public function get( $id ) {
		if ( ! $this->has( $id ) ) {
			throw new ArrayContainerKeyNotFoundException( $id );
		}

		return $this->data[ $id ];
	}

	public function has( $id ): bool {
		return array_key_exists( $id, $this->data );
	}

	public function set( string $id, $value ): void {
		$this->data[ $id ] = $value;
	}

	public function all(): array {
		return $this->data;
	}
}

class ArrayContainerKeyNotFoundException extends \RuntimeException implements NotFoundExceptionInterface {

	public function __construct( $id ) {
		parent::__construct( sprintf( 'Key "%s" not found in container.', $id ) );
	}
}
