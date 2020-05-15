<?php

namespace WPDesk\Forms\Field;

use WPDesk\Forms\NoValueField;

class SubmitField extends NoValueField {
	public function get_template_name() {
		return 'input-submit';
	}

	public function get_type() {
		return 'submit';
	}

	public function should_override_form_template() {
		return true;
	}
}
