<?php

namespace WPDesk\Forms\Field;

use IteratorAggregate;
use Traversable;
use WPDesk\Forms\Field;

/**
 * Represents a field that groups other fields.
 *
 * @template-extends IteratorAggregate<int, Field>
 */
interface CompositeField extends IteratorAggregate {

	/**
	 * @return Field[]
	 */
	public function get_fields(): array;

	/**
	 * @return Traversable<Field>
	 */
	public function getIterator(): Traversable;
}
