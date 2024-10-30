<?php

namespace WPDesk\Forms\Sanitizer;

use WPDesk\Forms\Sanitizer;

class EmailSanitizer implements Sanitizer {

	public function sanitize( $value ): string {
		return sanitize_email( $value );
	}
}
