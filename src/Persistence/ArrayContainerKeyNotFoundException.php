<?php

namespace WPDesk\Forms\Persistence;

use Psr\Container\NotFoundExceptionInterface;

class ArrayContainerKeyNotFoundException extends \RuntimeException implements NotFoundExceptionInterface {

	public function __construct( string $id ) {
		parent::__construct( sprintf( 'Key "%s" not found in container.', $id ) );
	}
}
