<?php
/**
 * @var \WPDesk\ShopMagic\FormField\Field $field
 * @var ShopMagicVendor\WPDesk\View\Renderer\Renderer $renderer
 * @var string $name_prefix
 * @var string $value
 *
 * @var string $template_name Real field template.
 *
 */
?>
<?php echo $renderer->render('input', [
	'field' => $field,
	'renderer' => $renderer,
	'name_prefix' => $name_prefix,
	'value' => $value,
]); ?>
