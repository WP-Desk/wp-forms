<?php

namespace WPDesk\Forms\Validator;

use WPDesk\Forms\Validator;

class RequiredValidator implements Validator {
	public function is_valid( $value ) {
		return $value !== null;
	}

	public function get_messages() {
		return [];
	}

}
