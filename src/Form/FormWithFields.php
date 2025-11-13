<?php

namespace WPDesk\Forms\Form;

use Psr\Container\ContainerInterface;
use WPDesk\Forms\ContainerForm;
use WPDesk\Forms\Field;
use WPDesk\Forms\FieldProvider;
use WPDesk\Forms\Form;
use WPDesk\Persistence\ElementNotExistsException;
use WPDesk\Persistence\PersistentContainer;
use WPDesk\View\Renderer\Renderer;

class FormWithFields implements Form, ContainerForm, FieldProvider {
	use Field\Traits\HtmlAttributes;

	/** @var string Unique form_id. */
	protected $form_id = 'form';

	/** @var array<string, mixed> */
	private $updated_data = [];

	/** @var array<string, mixed> */
	private $raw_data = [];

	/** @var array<string, string[]> */
	private $validation_messages = [];

	/** @var bool */
	private $submitted = false;

	/** @var bool */
	private $is_validated = false;

	/** @var bool */
	private $validation_result = true;

	/** @var Field[] Form fields. */
	private $fields;

	/**
	 * FormWithFields constructor.
	 *
	 * @param Field[] $fields
	 * @param string  $form_id
	 */
	public function __construct( array $fields, string $form_id = 'form' ) {
		$this->fields  = $fields;
		$this->form_id = $form_id;
		$this->set_action( '' );
		$this->set_method( 'POST' );
		$this->updated_data = [];
		$this->raw_data     = [];
	}

	/** Set Form action attribute. */
	public function set_action( string $action ): self {
		$this->attributes['action'] = $action;

		return $this;
	}

	public function get_action(): string {
		return $this->attributes['action'];
	}

	/** Set Form method attribute ie. GET/POST. */
	public function set_method( string $method ): self {
		$this->attributes['method'] = $method;

		return $this;
	}

	public function get_method(): string {
		return $this->attributes['method'];
	}


	public function is_submitted(): bool {
		return $this->submitted;
	}

	/** @return void */
	public function add_field( Field $field ) {
		$this->fields[] = $field;
	}

	public function is_active(): bool {
		return true;
	}

	/**
	 * Add more fields to form.
	 *
	 * @param Field[] $fields Field to add to form.
	 *
	 * @return void
	 */
	public function add_fields( array $fields ) {
		array_map( [ $this, 'add_field' ], $fields );
	}

	public function is_valid(): bool {
		if ( $this->is_validated ) {
			return $this->validation_result;
		}

		$this->validation_messages = [];
		$is_valid = true;

		foreach ( $this->all_fields() as $field ) {
			$field_name = $field->get_name();
			if ( '' === $field_name ) {
				continue;
			}

			$value     = $this->resolve_value( $field );
			$validator = $field->get_validator();

			if ( ! $validator->is_valid( $value ) ) {
				$is_valid = false;
				$messages = $validator->get_messages();
				if ( ! empty( $messages ) ) {
					$this->validation_messages[ $field_name ] = $messages;
				}
			}
		}

		$this->is_validated      = true;
		$this->validation_result = $is_valid;

		return $is_valid;
	}

	public function get_validation_messages(): array {
		return $this->validation_messages;
	}

	public function get_field_messages( string $field_name ): array {
		return $this->validation_messages[ $field_name ] ?? [];
	}

	/**
	 * Allows consumers to act on each validation message (e.g., add WP notices).
	 *
	 * @param callable $callback fn( string $field_name, string $message ): void
	 *
	 * @return void
	 */
	public function dispatch_validation_messages( callable $callback ): void {
		foreach ( $this->validation_messages as $field => $messages ) {
			foreach ( $messages as $message ) {
				$callback( $field, $message );
			}
		}
	}

	/**
	 * Add array to update data.
	 */
	public function handle_request( array $request = [] ) {
		$this->submitted           = true;
		$this->raw_data            = [];
		$this->validation_messages = [];
		$this->is_validated        = false;
		$this->validation_result   = true;

		foreach ( $this->all_fields() as $field ) {
			$data_key = $field->get_name();
			if ( '' === $data_key ) {
				continue;
			}
			if ( array_key_exists( $data_key, $request ) ) {
				$this->raw_data[ $data_key ]     = $request[ $data_key ];
				$this->updated_data[ $data_key ] = $field->get_sanitizer()->sanitize( $request[ $data_key ] );
			}
		}
	}

	/**
	 * Data could be saved in some place. Use this method to transmit them to form.
	 *
	 * @return void
	 */
	public function set_data( ContainerInterface $data ) {
		foreach ( $this->all_fields() as $field ) {
			$data_key = $field->get_name();
			if ( '' === $data_key ) {
				continue;
			}
			if ( $data->has( $data_key ) ) {
				try {
					$this->updated_data[ $data_key ] = $data->get( $data_key );
				} catch ( ElementNotExistsException $e ) {
					$this->updated_data[ $data_key ] = false;
				}
			}
		}
	}

	/** Renders only fields without form. */
	public function render_fields( Renderer $renderer ): string {
		$content     = '';
		$fields_data = $this->get_data();
		foreach ( $this->get_fields() as $field ) {
			$content .= $renderer->render(
				$field->should_override_form_template() ? $field->get_template_name() : 'form-field',
				[
					'field'         => $field,
					'renderer'      => $renderer,
					'name_prefix'   => $this->get_form_id(),
					'value'         => $this->resolve_render_value( $field, $fields_data ),
					'template_name' => $field->get_template_name(),
				]
			);
		}

		return $content;
	}

	public function render_form( Renderer $renderer ): string {
		$content  = $renderer->render(
			'form-start',
			[
				'form'   => $this,
				'method' => $this->get_method(), // backward compat.
				'action' => $this->get_action(),  // backward compat.
			]
		);
		$content .= $this->render_fields( $renderer );
		$content .= $renderer->render( 'form-end' );

		return $content;
	}

	public function put_data( PersistentContainer $container ) {
		$normalized = $this->get_normalized_data();
		foreach ( $normalized as $key => $value ) {
			$container->set( $key, $value );
		}
	}

	public function get_data(): array {
		if ( empty( $this->get_fields() ) ) {
			return [];
		}

		$data = $this->updated_data ?? [];

		foreach ( $this->all_fields() as $field ) {
			$data_key = $field->get_name();
			if ( '' === $data_key ) {
				continue;
			}
			if ( ! array_key_exists( $data_key, $data ) ) {
				$data[ $data_key ] = $field->get_default_value();
			}
		}

		if ( $this->is_submitted() ) {
			foreach ( $this->raw_data as $key => $value ) {
				$data[ $key ] = $value;
			}
		}

		return $data;
	}

	public function get_fields(): array {
		$fields = $this->fields;

		usort(
			$fields,
			static function ( Field $a, Field $b ) {
				return $a->get_priority() <=> $b->get_priority();
			}
		);

		return $fields;
	}

	public function get_form_id(): string {
		return $this->form_id;
	}

	public function get_normalized_data(): array {
		$data = $this->updated_data ?? [];

		foreach ( $this->all_fields() as $field ) {
			$data_key = $field->get_name();
			if ( '' === $data_key ) {
				continue;
			}

			if ( ! array_key_exists( $data_key, $data ) ) {
				$data[ $data_key ] = $field->get_default_value();
			}
		}

		return $data;
	}

	private function all_fields(): array {
		$flat_fields = [];
		$stack       = $this->fields;

		while ( ! empty( $stack ) ) {
			$field = array_shift( $stack );
			if ( ! $field instanceof Field ) {
				continue;
			}

			$flat_fields[] = $field;

			if ( $field instanceof \Traversable ) {
				foreach ( $field as $child ) {
					if ( $child instanceof Field ) {
						$stack[] = $child;
					}
				}
			}
		}

		return $flat_fields;
	}

	private function resolve_value( Field $field ) {
		$name = $field->get_name();

		if ( $name === '' ) {
			return null;
		}

		if ( array_key_exists( $name, $this->updated_data ) ) {
			return $this->updated_data[ $name ];
		}

		return $field->get_default_value();
	}

	private function resolve_render_value( Field $field, array $fields_data ) {
		if ( $field instanceof \Traversable ) {
			$values = [];
			foreach ( $field as $child ) {
				if ( ! $child instanceof Field ) {
					continue;
				}
				$values[ $child->get_name() ] = $this->resolve_render_value( $child, $fields_data );
			}

			return $values;
		}

		$name = $field->get_name();
		if ( '' === $name ) {
			return null;
		}

		if ( $this->is_submitted() && array_key_exists( $name, $this->raw_data ) ) {
			return $this->raw_data[ $name ];
		}

		return $fields_data[ $name ] ?? $field->get_default_value();
	}
}
