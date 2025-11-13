<?php
/**
 * PHPUnit bootstrap file
 */

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/stubs/TestField.php';

WP_Mock::setUsePatchwork( true );
WP_Mock::bootstrap();

if ( ! function_exists( 'sanitize_text_field' ) ) {
	/**
	 * Simplified version used for unit tests.
	 *
	 * @param mixed $value Value to sanitize.
	 *
	 * @return string
	 */
	function sanitize_text_field( $value ) {
		if ( is_array( $value ) || is_object( $value ) ) {
			return '';
		}

		return trim( (string) $value );
	}
}
