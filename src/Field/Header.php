<?php

namespace WPDesk\Forms\Field;

use WPDesk\Forms\NoValueField;

class Header extends NoValueField {
	public function __construct() {
		$this->meta['header_size'] = '';
	}

	public function get_template_name() {
		return 'header';
	}

	public function should_override_form_template() {
		return true;
	}

	public function set_header_size( $value ) {
		$this->meta['header_size'] = $value;

		return $this;
	}
}
