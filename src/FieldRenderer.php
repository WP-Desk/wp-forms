<?php

namespace WPDesk\Forms;

interface FieldRenderer {

	/**
	 * @param array<string, mixed> $fields_data String keyed form data.
	 * @return string|array String or normalized array
	 */
	public function render_fields( FieldProvider $provider, array $fields_data, string $name_prefix = '' );
}
