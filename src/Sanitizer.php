<?php

namespace WPDesk\Forms;

interface Sanitizer {
	/** @param mixed $value */
	public function sanitize( $value ): string;
}
