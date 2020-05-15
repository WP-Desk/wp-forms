<?php

namespace WPDesk\Forms;


use Psr\Container\ContainerInterface;
use WPDesk\View\Renderer\Renderer;

/**
 * Abstraction layer for forms.
 *
 * @package WPDesk\Forms
 */
interface Form {
	/**
	 * Checks if form should be active.
	 *
	 * @return bool
	 */
	public function is_active();

	public function is_submitted();

	public function is_valid();

	/**
	 * Add array to update data.
	 *
	 * @param array|ContainerInterface $request new data to update.
	 */
	public function handle_request( $request = array() );

	/**
	 * @param array|ContainerInterface $data
	 */
	public function set_data( $data );

	public function render_form( Renderer $renderer );

	public function get_data();

	public function get_normalized_data();

	/**
	 * return form Id
	 *
	 * @return string
	 */
	public function get_form_id();
}

