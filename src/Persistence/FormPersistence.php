<?php

namespace WPDesk\Forms\Persistence;

use WPDesk\Forms\FieldProvider;
use WPDesk\Forms\Form\FormWithFields;
use WPDesk\Persistence\PersistentContainer;

class FormPersistence {

	/** @var FieldProvider */
	private $provider;

	/** @var FieldPersistenceStrategy */
	private $strategy;

	public function __construct( FieldProvider $provider, PersistentContainer $persistence ) {
		$this->provider = $provider;
		$this->strategy = new FieldPersistenceStrategy( $persistence );
	}

	public static function for_form( FieldProvider $form, PersistentContainer $persistence ): self {
		return new self( $form, $persistence );
	}

	public function save_form( FormWithFields $form ): void {
		$this->strategy->persist_fields( $this->provider, $form->get_normalized_data() );
	}

	/**
	 * @return array<string, mixed>
	 */
	public function load(): array {
		return $this->strategy->load_fields( $this->provider );
	}

	public function hydrate_form( FormWithFields $form ): void {
		$form->set_data( new ArrayContainer( $this->load() ) );
	}
}
