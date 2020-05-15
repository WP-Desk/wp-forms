<?php
/**
 * @var \WPDesk\ShopMagic\FormField\Field $field
 * @var string $name_prefix
 * @var string $value
 */
?>

<?php if ( ! in_array( $field->get_type(), [ 'text', 'hidden' ] ) ): ?>
	<input type="hidden" name="<?php echo $name_prefix; ?>[<?php echo $field->get_name(); ?>]" value="no"/>
<?php endif; ?>

<?php if ( $field->get_type() === 'checkbox' && $field->has_sublabel() ) : ?>
<label>
<?php endif; ?>

<input
	type="<?php echo esc_attr( $field->get_type() ); ?>"
	name="<?php echo esc_attr( $name_prefix ); ?>[<?php echo esc_attr( $field->get_name() ); ?>]"
	id="<?php echo esc_attr( $field->get_id() ); ?>"

	<?php if ( $field->has_classes() ): ?>class="<?php echo esc_attr( $field->get_classes() ); ?>"<?php endif; ?>

	<?php if ( $field->get_type() === 'text' && $field->has_placeholder() ): ?>placeholder="<?php echo esc_html( $field->get_placeholder() ); ?>"<?php endif; ?>

<?php foreach ( $field->get_attributes() as $key => $atr_val ): ?>
<?php echo $key ?>="<?php echo esc_attr( $atr_val ); ?>"
<?php endforeach; ?>

<?php if ( $field->is_required() ): ?>required="required"<?php endif; ?>
<?php if ( $field->is_disabled() ): ?>disabled="disabled"<?php endif; ?>
<?php if ( $field->is_readonly() ): ?>readonly="readonly"<?php endif; ?>

<?php if ( in_array( $field->get_type(), [ 'text', 'hidden' ] ) ): ?>
	value="<?php echo esc_html( $value ); ?>"
<?php else: ?>
	value="yes"
	<?php if ( $value === 'yes' ): ?>checked="checked"<?php endif; ?>
<?php endif; ?>
/>

<?php if ( $field->get_type() === 'checkbox' && $field->has_sublabel() ) : ?>
	<?php echo esc_html( $field->get_sublabel() ); ?></label>
<?php endif; ?>
