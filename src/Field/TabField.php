<?php

namespace WPDesk\Forms\Field;

/**
 * Represents a tab that contains other fields.
 */
class TabField extends GroupField {

	/** @var string */
	private $tab_id = '';

	public function set_tab_id( string $tab_id ): self {
		$this->tab_id = $tab_id;

		return $this;
	}

	public function get_tab_id(): string {
		return $this->tab_id;
	}

	public function get_template_name(): string {
		return 'tab';
	}
}
