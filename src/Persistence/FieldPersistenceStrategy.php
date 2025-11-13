<?php

namespace WPDesk\Forms\Persistence;

use Psr\Container\NotFoundExceptionInterface;
use WPDesk\Forms\FieldProvider;
use WPDesk\Persistence\PersistentContainer;

/**
 * Can save/load provided fields to/from PersistentContainer.
 *
 * @package WPDesk\Forms
 */
class FieldPersistenceStrategy {

	/** @var PersistentContainer */
	private $persistence;

	public function __construct( PersistentContainer $persistence ) {
		$this->persistence = $persistence;
	}

	/** @return void */
	public function persist_fields( FieldProvider $fields_provider, array $data ) {
		foreach ( $fields_provider->get_fields() as $field ) {
			$field_key = $field->get_name();

			if ( '' === $field_key ) {
				continue;
			}

			$value = array_key_exists( $field_key, $data ) ? $data[ $field_key ] : $field->get_default_value();

			if ( $field->has_serializer() ) {
				$value = $field->get_serializer()->serialize( $value );
			}

			$this->persistence->set( $field_key, $value );
		}
	}

	/** @return void */
	public function load_fields( FieldProvider $fields_provider ): array {
		$data = [];
		foreach ( $fields_provider->get_fields() as $field ) {
			$field_key = $field->get_name();
			try {
				if ( $field->has_serializer() ) {
					$data[ $field_key ] = $field->get_serializer()->unserialize( $this->persistence->get( $field_key ) );
				} else {
					$data[ $field_key ] = $this->persistence->get( $field_key );
				}
			} catch ( NotFoundExceptionInterface $not_found ) {
				$data[ $field_key ] = $field->get_default_value();
			}
		}

		return $data;
	}
}
