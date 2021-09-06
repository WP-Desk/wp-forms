<?php

namespace WPDesk\Forms;

interface Serializer {
	/**
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function serialize( $value );

	/**
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public function unserialize( $value );
}
