<?php
/**
 * @var \WPDesk\Forms\Field\TabField    $field
 * @var \WPDesk\View\Renderer\Renderer  $renderer
 * @var string                          $name_prefix
 * @var array<string, mixed>            $value
 */

?>
<div class="wpdesk-forms-tab" id="<?php echo esc_attr( $field->get_tab_id() ); ?>">
	<?php if ( $field->has_label() ) : ?>
		<h2><?php echo esc_html( $field->get_label() ); ?></h2>
	<?php endif; ?>

	<?php if ( $field->has_description() ) : ?>
		<p class="description"><?php echo wp_kses_post( $field->get_description() ); ?></p>
	<?php endif; ?>

	<?php foreach ( $field->get_fields() as $inner_field ) : ?>
		<?php
		$renderer->output_render(
			$inner_field->should_override_form_template() ? $inner_field->get_template_name() : 'form-field',
			[
				'field'         => $inner_field,
				'renderer'      => $renderer,
				'name_prefix'   => $name_prefix,
				'value'         => $value[ $inner_field->get_name() ] ?? '',
				'template_name' => $inner_field->get_template_name(),
			]
		);
		?>
	<?php endforeach; ?>
</div>
