<?php

namespace WPDesk\Forms\Field;

use WPDesk\Forms\Field;

class SelectField extends BasicField {

	public function get_template_name(): string {
		return 'select';
	}

	/** @param string[] $options */
	public function set_options( array $options ): Field {
		$this->meta['possible_values'] = $options;

		return $this;
	}

	public function set_multiple(): Field {
		$this->attributes['multiple'] = 'multiple';

		return $this;
	}
}
