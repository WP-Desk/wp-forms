<?php

use WPDesk\ShopMagic\Action\Builtin\SendMail\PlainMailTemplate;
use WPDesk\ShopMagic\Action\Builtin\SendMail\WooCommerceMailTemplate;

/**
 * @var \WPDesk\ShopMagic\FormField\Field $field
 * @var string $name_prefix
 * @var string $value
 */
?>
<select
	id="<?php echo esc_attr( $field->get_id() ); ?>"
	<?php if ($field->has_classes()): ?>class="<?php echo esc_attr( $field->get_classes() ); ?>"<?php endif; ?>
	name="<?php echo esc_attr( $name_prefix ); ?>[<?php echo esc_attr( $field->get_name() ); ?>]"
	<?php foreach ($field->get_attributes() as $key => $attr_val): ?>
		<?php echo esc_attr($key); ?>="<?php echo esc_attr($attr_val); ?>"
	<?php endforeach; ?>

	<?php if ($field->is_required()): ?>required="required"<?php endif; ?>
	<?php if ($field->is_disabled()): ?>disabled="disabled"<?php endif; ?>
	<?php if ($field->is_readonly()): ?>readonly="readonly"<?php endif; ?>
	<?php if ($field->is_multiple()): ?>multiple="multiple"<?php endif; ?>
>
	<?php if ( $field->has_placeholder() ): ?><option value=""><?php echo esc_html( $field->get_placeholder() ); ?></option><?php endif; ?>

	<?php foreach ( $field->get_possible_values() as $possible_value => $label ): ?>
		<option
			<?php if ( $possible_value === $value ): ?>selected="selected"<?php endif; ?>
			value="<?php echo esc_attr( $possible_value ); ?>"
		><?php echo esc_html( $label ); ?></option>
	<?php endforeach; ?>
</select>
