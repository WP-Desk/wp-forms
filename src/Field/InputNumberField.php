<?php

namespace WPDesk\Forms\Field;

use WPDesk\Forms\Sanitizer;
use WPDesk\Forms\Sanitizer\TextFieldSanitizer;

class InputNumberField extends BasicField {
	public function __construct() {
		parent::__construct();
		$this->set_default_value( '' );
		$this->set_attribute( 'type', 'number' );
	}

	public function get_sanitizer(): Sanitizer {
		return new TextFieldSanitizer();
	}

	public function get_template_name(): string {
		return 'input-number';
	}
}
