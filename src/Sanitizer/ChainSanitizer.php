<?php

namespace WPDesk\Forms\Sanitizer;

use WPDesk\Forms\Sanitizer;

/**
 * Runs multiple sanitizers sequentially.
 */
class ChainSanitizer implements Sanitizer {

	/** @var Sanitizer[] */
	private $sanitizers = [];

	/**
	 * @param Sanitizer[] $sanitizers
	 */
	public function __construct( array $sanitizers = [] ) {
		array_map( [ $this, 'attach' ], $sanitizers );
	}

	public function attach( Sanitizer $sanitizer ): void {
		$this->sanitizers[] = $sanitizer;
	}

	/**
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function sanitize( $value ) {
		$sanitized = $value;
		foreach ( $this->sanitizers as $sanitizer ) {
			$sanitized = $sanitizer->sanitize( $sanitized );
		}

		return $sanitized;
	}
}
