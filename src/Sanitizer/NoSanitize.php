<?php

namespace WPDesk\Forms\Sanitizer;

use WPDesk\Forms\Sanitizer;

class NoSanitize implements Sanitizer {
	public function sanitize( $value ) {
		return $value;
	}

}
