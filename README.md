# WP Forms

Reusable form field objects, renderers and persistence helpers for WordPress projects.

`wpdesk/wp-forms` is a Composer package, not a standalone WordPress plugin. It is intended to be used from code that already runs inside WordPress, for example a plugin settings page or another admin form.

## Requirements

- PHP `>=7.4 || ^8`
- PHP extensions: `ext-curl`, `ext-json`
- Composer packages: `wpdesk/wp-persistence` `^2.0|^3.0`, `wpdesk/wp-view` `^2`
- WordPress runtime for functions used by fields and templates, such as `sanitize_title()`, `sanitize_text_field()`, `sanitize_email()`, `wp_verify_nonce()`, `wp_editor()` and escaping helpers
- WooCommerce runtime only for templates and helpers that use WooCommerce functions, such as `wc_help_tip()`, `wc_get_product()` and the `woocommerce_json_search_products_and_variations` AJAX action

## Installation

Install the package as a runtime dependency:

```bash
composer require wpdesk/wp-forms
```

When working on this package itself, install development dependencies with:

```bash
composer install
```

## Autoloading

Load Composer's autoloader in your plugin or application:

```php
require_once __DIR__ . '/vendor/autoload.php';
```

The package uses the `WPDesk\Forms\` PSR-4 namespace mapped to `src/`.

## Basic Usage

Create field objects, pass them to `FormWithFields`, handle data submitted under the form ID and render the form with `SimplePhpRenderer` plus `DefaultFormFieldResolver`.

```php
<?php

use WPDesk\Forms\Field\CheckboxField;
use WPDesk\Forms\Field\InputEmailField;
use WPDesk\Forms\Field\SubmitField;
use WPDesk\Forms\Form\FormWithFields;
use WPDesk\Forms\Resolver\DefaultFormFieldResolver;
use WPDesk\View\Renderer\SimplePhpRenderer;

$fields = [
	( new InputEmailField() )
		->set_name( 'email' )
		->set_label( __( 'Email address', 'my-text-domain' ) )
		->set_required(),

	( new CheckboxField() )
		->set_name( 'subscribe' )
		->set_label( __( 'Subscription', 'my-text-domain' ) )
		->set_sublabel( __( 'Subscribe to the mailing list', 'my-text-domain' ) )
		->set_default_value( CheckboxField::VALUE_FALSE ),

	( new SubmitField() )
		->set_name( 'save' )
		->set_label( __( 'Save changes', 'my-text-domain' ) )
		->add_class( 'button-primary' ),
];

$form = new FormWithFields( $fields, 'newsletter_settings' );
$form->set_method( 'POST' );
$form->set_action( '' );

if ( isset( $_POST['newsletter_settings'] ) && is_array( $_POST['newsletter_settings'] ) ) {
	$form->handle_request( wp_unslash( $_POST['newsletter_settings'] ) );

	if ( $form->is_valid() ) {
		$data = $form->get_data();
		// Save $data in your persistence layer.
	}
}

$renderer = new SimplePhpRenderer( new DefaultFormFieldResolver() );

echo $form->render_form( $renderer );
```

Important behavior:

- `FormWithFields` renders request field names as `{form_id}[{field_name}]`.
- `handle_request()` reads only fields declared in the form and sanitizes values with each field's sanitizer.
- `is_valid()` must be called before saving submitted data if validation matters.
- `get_data()` returns submitted or loaded values and fills missing fields with their default values.
- `get_fields()` sorts fields by ascending priority; the default priority is `10`.

## Persistence

`FormWithFields::set_data()` can load values from a `Psr\Container\ContainerInterface` implementation.

`FormWithFields::put_data()` can write current form values to a `WPDesk\Persistence\PersistentContainer`, but it writes raw values only.

Use `WPDesk\Forms\Persistence\FieldPersistenceStrategy` when fields with serializers are involved, because it calls field serializers during save and load.

```php
use WPDesk\Forms\Persistence\FieldPersistenceStrategy;

$strategy = new FieldPersistenceStrategy( $persistent_container );

if ( isset( $_POST[ $form->get_form_id() ] ) && is_array( $_POST[ $form->get_form_id() ] ) ) {
	$form->handle_request( wp_unslash( $_POST[ $form->get_form_id() ] ) );

	if ( $form->is_valid() ) {
		$strategy->persist_fields( $form, $form->get_data() );
	}
}

$loaded_data = $strategy->load_fields( $form );
// Pass $loaded_data to your own field owner, container adapter or view layer.
```

## Rendering Fields as Data

Use `WPDesk\Forms\Renderer\JsonNormalizedRenderer` to convert fields to normalized arrays for custom frontends or JavaScript-driven UIs.

```php
use WPDesk\Forms\Renderer\JsonNormalizedRenderer;

$renderer = new JsonNormalizedRenderer();
$fields_data = $renderer->render_fields( $form, $form->get_data(), $form->get_form_id() );
```

## Available Fields

Text and input fields:

- `InputTextField`
- `InputEmailField`
- `InputNumberField`
- `HiddenField`
- `TextAreaField`
- `MultipleInputTextField`
- `DateField`
- `DatePickerField`
- `TimepickerField`
- `ImageInputField`
- `WPEditorField`

Choice fields:

- `CheckboxField`
- `ToggleField`
- `RadioField`
- `SelectField`
- `ProductSelect`
- `WooSelect`

Layout and action fields:

- `Header`
- `Paragraph`
- `ButtonField`
- `SubmitField`
- `NoOnceField`, which renders and validates a WordPress nonce field

Base classes:

- `BasicField` provides common fluent setters such as `set_name()`, `set_label()`, `set_description()`, `set_description_tip()`, `set_placeholder()`, `set_default_value()`, `set_required()`, `set_priority()`, `add_class()` and `add_data()`.
- `NoValueField` is the base class for display/action fields that normally do not process a submitted value.

Deprecated field:

- `WyswigField` is deprecated; use `WPEditorField` instead.

Template notes:

- `DefaultFormFieldResolver` resolves templates from the package `templates/` directory.
- `ProductSelect` depends on WooCommerce product lookup functions and admin AJAX behavior.
- `WooSelect` returns the `woo-select` template name and `TimepickerField` returns the `timepicker` template name. Matching templates are not bundled in this package, so provide them through your renderer/resolver setup before using these fields with the default renderer.

## Validators, Sanitizers and Serializers

Validators:

- `ChainValidator`
- `NoValidateValidator`
- `NonceValidator`
- `RequiredValidator`, attached automatically by `BasicField::set_required()`

Sanitizers:

- `NoSanitize`, the default sanitizer in `BasicField`
- `TextFieldSanitizer`, used by text-like fields
- `EmailSanitizer`, used by `InputEmailField`
- `CallableSanitizer`, for custom sanitizer callbacks

Serializers:

- `JsonSerializer`
- `ProductSelectSerializer`
- `SerializeSerializer`

Fields that return `true` from `has_serializer()` should be persisted through `FieldPersistenceStrategy` if you want serializer-aware save/load behavior.

## Development

Available Composer scripts:

```bash
composer phpcs
composer phpstan
composer phpcbf
composer phpunit-unit
composer phpunit-unit-fast
composer phpunit-integration
composer phpunit-integration-fast
```

## License

This package is released under the MIT license.
