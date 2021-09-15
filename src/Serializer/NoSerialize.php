<?php

namespace WPDesk\Forms\Serializer;

use WPDesk\Forms\Serializer;

class NoSerialize implements Serializer {
	public function serialize( $value ): string {
		return (string) $value;
	}

	public function unserialize( string $value ) {
		return $value;
	}

}
