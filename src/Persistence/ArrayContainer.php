<?php

namespace WPDesk\Forms\Persistence;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ArrayContainer implements ContainerInterface {

	/** @var array<string, mixed> */
	private $data = [];

	/**
	 * @param array<string, mixed> $data
	 */
	public function __construct( array $data = [] ) {
		$this->data = $data;
	}

	/**
	 * @param mixed $id
	 * @return mixed
	 */
	public function get( $id ) {
		$key = $this->assert_string_key( $id );
		if ( ! array_key_exists( $key, $this->data ) ) {
			throw new ArrayContainerKeyNotFoundException( $key );
		}

		return $this->data[ $key ];
	}

	/**
	 * @param mixed $id
	 */
	public function has( $id ): bool {
		if ( ! is_string( $id ) ) {
			return false;
		}

		return array_key_exists( $id, $this->data );
	}

	/**
	 * @param mixed $value
	 */
	public function set( string $id, $value ): void {
		$this->data[ $id ] = $value;
	}

	/**
	 * @return array<string, mixed>
	 */
	public function all(): array {
		return $this->data;
	}

	/**
	 * @param mixed $id
	 */
	private function assert_string_key( $id ): string {
		if ( ! is_string( $id ) ) {
			throw new ArrayContainerKeyNotFoundException( $this->stringify_id( $id ) );
		}

		return $id;
	}

	/**
	 * @param mixed $id
	 */
	private function stringify_id( $id ): string {
		if ( is_scalar( $id ) || ( is_object( $id ) && method_exists( $id, '__toString' ) ) ) {
			return (string) $id;
		}

		return gettype( $id );
	}
}
