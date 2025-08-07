<?php
/**
 * @var \WPDesk\Forms\Field $field
 * @var \WPDesk\View\Renderer\Renderer $renderer
 * @var string $name_prefix
 * @var string $value
 * @var string $template_name Real field template.
 */

?>
	<style>
		input[type="checkbox"].wpd-toggle-field {
			position: absolute;
			opacity: 0;
			width: 32px;
			height: 16px;
			margin: 0;
		}

		.wpd-toggle-label {
			display: inline-block;
			width: 32px;
			height: 16px;
			background: #fff;
			border: 1px solid #949494;
			border-radius: 200px;
			position: relative;
			cursor: pointer;
			transition: background 0.25s, border-color 0.25s;
			vertical-align: middle;
		}

		.wpd-toggle-label::before {
			content: "";
			display: block;
			height: 14px;
			width: 14px;
			background: #1c1c1c;
			border-radius: 50%;
			position: absolute;
			left: 1px;
			top: 1px;
			transition: 0.25s;
			transition-timing-function: ease-out;
		}

		input[type="checkbox"].wpd-toggle-field:checked + .wpd-toggle-label {
			background: var(--wp-admin-theme-color, #1851e0);
			border-color: var(--wp-admin-theme-color, #1851e0);
		}

		input[type="checkbox"].wpd-toggle-field:checked + .wpd-toggle-label::before {
			left: 17px;
			background: #fff;
		}
	</style>
<?php
$renderer->output_render(
	'input',
	[
		'field'       => $field,
		'renderer'    => $renderer,
		'name_prefix' => $name_prefix,
		'value'       => $value,
	]
);
