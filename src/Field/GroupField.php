<?php

namespace WPDesk\Forms\Field;

use ArrayIterator;
use Traversable;
use WPDesk\Forms\Field;

/**
 * Basic implementation for composable field groups.
 */
class GroupField extends NoValueField implements CompositeField {

	/** @var Field[] */
	private $fields = [];

	/**
	 * @param Field[] $fields
	 */
	public function __construct( array $fields = [] ) {
		parent::__construct();

		$this->fields = $fields;
	}

	/**
	 * @param Field[] $fields
	 *
	 * @return $this
	 */
	public function set_fields( array $fields ): self {
		$this->fields = $fields;

		return $this;
	}

	/**
	 * @return Field[]
	 */
	public function get_fields(): array {
		return $this->fields;
	}

	public function add_field( Field $field ): self {
		$this->fields[] = $field;

		return $this;
	}

	/**
	 * @return Traversable<Field>
	 */
	public function getIterator(): Traversable {
		return new ArrayIterator( $this->get_fields() );
	}

	public function get_template_name(): string {
		return 'section';
	}

	public function should_override_form_template(): bool {
		return true;
	}
}
