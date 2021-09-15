<?php

namespace WPDesk\Forms;

use Psr\Container\ContainerInterface;
use WPDesk\Persistence\PersistentContainer;
use Psr\Container\ContainerInterface;

/**
 * Persistent container support for forms.
 *
 * @package WPDesk\Forms
 */
interface ContainerForm {
	/**
	 * @param ContainerInterface $data
	 *
	 * @return void
	 */
	public function set_data( ContainerInterface $data );

	/**
	 * Put data from form into a container.
	 *
	 * @return void
	 */
	public function put_data( PersistentContainer $container );
}

