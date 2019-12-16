<?php

namespace WPDesk\Forms;


/**
 * Abstraction layer for forms.
 *
 * @package WPDesk\Forms
 */
abstract class AbstractForm {

	/**
	 * Unique form_id.
	 *
	 * @var string
	 */
	protected $form_id = 'form';

	/**
	 * Updated data.
	 *
	 * @var array
	 */
	protected $updated_data = array();


	/**
	 * Create form data and return an associative array.
	 *
	 * @return array
	 */
	abstract protected function create_form_data();

	/**
	 * Add array to update data.
	 *
	 * @param array $new_data new data to update.
	 */
	public function update_form_data( array $new_data = array() ) {
		$this->updated_data = $new_data;
	}

	/**
	 * Merge created and updated data and return associative array. Add to all keys form prefix.
	 *
	 * @return array
	 */
	public function get_form_data() {
		return array_merge(
			$this->create_form_data(),
			$this->updated_data
		);
	}

	/**
	 * return form Id
	 *
	 * @return string
	 */
	public function get_form_id() {
		return $this->form_id;
	}

}

