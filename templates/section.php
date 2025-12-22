<?php
/**
 * @var \WPDesk\Forms\Field\GroupField $field
 * @var \WPDesk\View\Renderer\Renderer  $renderer
 * @var string                          $name_prefix
 * @var array<string, mixed>            $value
 */

?>
<section class="wpdesk-forms-section">
	<?php if ( $field->has_label() ) : ?>
		<h3><?php echo esc_html( $field->get_label() ); ?></h3>
	<?php endif; ?>

	<?php if ( $field->has_description() ) : ?>
		<p class="description"><?php echo wp_kses_post( $field->get_description() ); ?></p>
	<?php endif; ?>

	<table class="form-table">
		<tbody>
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
		</tbody>
	</table>
</section>
