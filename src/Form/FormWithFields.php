<?php

namespace WPDesk\Forms\Form;

use Psr\Container\ContainerInterface;
use WPDesk\Forms\Field;
use WPDesk\Forms\FieldProvider;
use WPDesk\Forms\Form;
use WPDesk\Persistence\Adapter\ArrayContainer;
use WPDesk\Persistence\ElementNotExistsException;
use WPDesk\View\Renderer\Renderer;

class FormWithFields implements Form, FieldProvider {
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
	private $updated_data;
	/**
	 * @var Field[]
	 */
	private $fields;

	public function __construct( array $fields, $form_id = 'form' ) {
		$this->fields       = $fields;
		$this->form_id      = $form_id;
		$this->updated_data = null;
	}

	public function is_submitted() {
		return $this->updated_data !== null;
	}

	public function add_field( Field $field ) {
		$this->fields[] = $field;
	}

	/**
	 * Checks if form should be active.
	 *
	 * @return bool
	 */
	public function is_active() {
		return true;
	}

	/**
	 * @param Field[] $fields
	 */
	public function add_fields( array $fields ) {
		array_map( [ $this, 'add_field' ], $fields );
	}

	public function is_valid() {
		foreach ( $this->fields as $field ) {
			$field_value     = isset( $this->updated_data[ $field->get_name() ] ) ? $this->updated_data[ $field->get_name() ] : null;
			$field_validator = $field->get_validator();
			if ( ! $field_validator->is_valid( $field_value ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Add array to update data.
	 *
	 * @param array|ContainerInterface $request new data to update.
	 */
	public function handle_request( $request = array() ) {
		if ( $this->updated_data === null ) {
			$this->updated_data = [];
		}
		foreach ( $this->fields as $field ) {
			$data_key = $field->get_name();
			if ( isset( $request[ $data_key ] ) ) {
				$this->updated_data[ $data_key ] = $field->get_sanitizer()->sanitize( $request[ $data_key ] );
			}
		}
	}

	/**
	 * @param array|ContainerInterface $data
	 */
	public function set_data( $data ) {
		if ( is_array( $data ) ) {
			$data = new ArrayContainer( $data );
		}
		foreach ( $this->fields as $field ) {
			$data_key = $field->get_name();
			if ( $data->has( $data_key ) ) {
				try {
					$this->updated_data[ $data_key ] = $data->get( $data_key );
				} catch ( ElementNotExistsException $e ) {
					$this->updated_data[ $data_key ] = false;
				}
			}
		}
	}

	public function render_form( Renderer $renderer ) {
		$fields_data = $this->get_data();

		$content = $renderer->render( 'form-start', [
			'method' => 'POST',
			'action' => ''
		] );

		foreach ( $this->get_fields() as $field ) {
			$content .= $renderer->render( $field->should_override_form_template() ? $field->get_template_name() : 'form-field',
				[
					'field'         => $field,
					'renderer'      => $renderer,
					'name_prefix'   => $this->get_form_id(),
					'value'         => isset( $fields_data[ $field->get_name() ] ) ? $fields_data[ $field->get_name() ] : $field->get_default_value(),
					'template_name' => $field->get_template_name(),
				] );
		}

		$content .= $renderer->render( 'form-end' );

		return $content;
	}

	public function get_data() {
		$data = $this->updated_data;

		foreach ( $this->get_fields() as $field ) {
			$data_key = $field->get_name();
			if ( ! isset( $data[ $data_key ] ) ) {
				$data[ $data_key ] = $field->get_default_value();
			}
		}

		return $data;
	}

	public function get_fields() {
		return $this->fields;
	}

	/**
	 * return form Id
	 *
	 * @return string
	 */
	public function get_form_id() {
		return $this->form_id;
	}

	public function get_normalized_data() {
		return $this->get_data();
	}
}
