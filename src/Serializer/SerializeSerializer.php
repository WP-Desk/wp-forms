<?php

namespace WPDesk\Forms\Serializer;

use WPDesk\Forms\Serializer;

class SerializeSerializer implements Serializer {
	public function serialize( $value ) {
		return serialize( $value );
	}

	public function unserialize( $value ) {
		return unserialize( $value );
	}

}
