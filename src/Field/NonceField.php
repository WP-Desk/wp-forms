<?php

namespace WPDesk\Forms\Field;

use WPDesk\Forms\Validator;
use WPDesk\Forms\Validator\NonceValidator;

class NonceField extends BasicField {

	/** @var string */
	private $action;

	public function __construct( string $action_name, string $field_name = '_wpnonce' ) {
		$this->action          = $action_name;
		$this->meta['action']  = $action_name;
		$this->set_name( $field_name );
	}

	public function get_validator(): Validator {
		return new NonceValidator( $this->action );
	}

	public function get_template_name(): string {
		return 'noonce';
	}
}
