<?php

namespace WPDesk\Forms\Field;

class WyswigField extends BasicField {
	public function __construct() {
		parent::__construct();
		$this->set_default_value( '' );
	}

	public function get_template_name(): string {
		return 'wyswig';
	}

	public function should_override_form_template(): bool {
		return true;
	}
}
