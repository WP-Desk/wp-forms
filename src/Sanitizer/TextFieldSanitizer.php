<?php

namespace WPDesk\Forms\Sanitizer;

use WPDesk\Forms\Sanitizer;

class TextFieldSanitizer implements Sanitizer {
	public function sanitize( $value ) {
		return sanitize_text_field( $value );
	}

}
