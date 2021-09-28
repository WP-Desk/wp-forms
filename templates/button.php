<?php
/**
 * @var \WPDesk\Forms\Field $field
 * @var \WPDesk\View\Renderer\Renderer $renderer
 * @var string $name_prefix
 * @var string $value
 * @var string $template_name Real field template.
 */

?>

<button
<?php if ( $field->has_classes() ) : ?>
	class="<?php echo \esc_attr( $field->get_classes() ); ?>"
<?php endif; ?>

<?php foreach ( $field->get_attributes( [] ) as $key => $val ) : ?>
	<?php echo \esc_attr( $key ) . '="' . \esc_attr( $val ) . '"'; ?>
<?php endforeach; ?>

	type="<?php echo \esc_attr( $field->get_type() ); ?>"
	name="<?php echo \esc_attr( $name_prefix ) . '[' . \esc_attr( $field->get_name() ) . ']'; ?>"
	id="<?php echo \esc_attr( $field->get_id() ); ?>"
	value="<?php echo \esc_html( $value ); ?>"

	<?php
	if ( $field->is_disabled() ) :
		?>
		disabled="disabled"<?php endif; ?>
	<?php
	if ( $field->is_readonly() ) :
		?>
		readonly="readonly"<?php endif; ?>

><?php echo \esc_html( $field->get_label() ); ?></button>

