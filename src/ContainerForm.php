<?php

namespace WPDesk\Forms;

use WPDesk\Persistence\PersistentContainer;

/**
 * Persistent container support for forms.
 *
 * @package WPDesk\Forms
 */
interface ContainerForm {
	/**
	 * @param \Psr\Container\ContainerInterface $data
	 *
	 * @return void
	 */
	public function set_data( $data );

	/**
	 * Put data from form into a container.
	 *
	 * @return void
	 */
	public function put_data( PersistentContainer $container );
}

