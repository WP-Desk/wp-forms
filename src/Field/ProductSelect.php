<?php

namespace WPDesk\Forms\Field;

class ProductSelect extends SelectField {
	public function __construct() {
		$this->set_multiple();
	}

	public function get_template_name(): string {
		return 'product-select';
	}
}
