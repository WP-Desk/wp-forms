<?php

declare(strict_types=1);

namespace WPDesk\Forms\Tests\Stubs;

use WPDesk\Forms\Field\BasicField;

class TestField extends BasicField {

	public function get_template_name(): string {
		return 'input-text';
	}
}
