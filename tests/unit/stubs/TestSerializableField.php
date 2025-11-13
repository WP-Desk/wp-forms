<?php

declare(strict_types=1);

namespace WPDesk\Forms\Tests\Stubs;

use WPDesk\Forms\Field\BasicField;
use WPDesk\Forms\Serializer;

class TestSerializableField extends BasicField {

	/** @var Serializer */
	private $serializer;

	public function __construct( Serializer $serializer ) {
		$this->serializer = $serializer;
	}

	public function get_template_name(): string {
		return 'input-text';
	}

	public function has_serializer(): bool {
		return true;
	}

	public function get_serializer(): Serializer {
		return $this->serializer;
	}
}
