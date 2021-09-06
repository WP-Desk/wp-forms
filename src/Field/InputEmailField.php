<?php

namespace WPDesk\Forms\Field;

use WPDesk\Forms\Sanitizer;
use WPDesk\Forms\Sanitizer\EmailSanitizer;

class InputEmailField extends BasicField {
	public function __construct() {
		parent::__construct();
		$this->set_default_value( '' );
		$this->set_attribute( 'type', 'email' );
	}

	public function get_sanitizer(): Sanitizer {
		return new EmailSanitizer();
	}

	public function get_template_name(): string {
		return 'input-text';
	}
}
