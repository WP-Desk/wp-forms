WordPress Library for Form integration
===================================================

## Requirements

PHP 7.4 or later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require --dev wpdesk/wp-forms
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once 'vendor/autoload.php';
```

## Usage

Let's say we have an abstraction for settings tabs:
```php
interface SettingsTab {
	/**
	 * Slug name used for unique url and settings in db.
	 */
	public static function get_tab_slug(): string;

	/**
	 * Tab name to show on settings page.
	 */
	public function get_tab_name(): string;

	/**
	 * Render tab content and return it as string.
	 */
	public function render( Renderer $renderer ): string;

	/**
	 * Use to set settings from database or defaults.
	 *
	 * @param ContainerInterface $data Data to render.
	 *
	 * @return void
	 */
	public function set_data( ContainerInterface $data );

	/**
	 * Use to handle request data from POST.
	 * Data in POST request should be prefixed with slug.
	 * For example if slug is 'stefan' and the input has name 'color' and value 'red' then the data should be sent as
	 * $_POST = [ 'stefan' => [ 'color' => 'red' ] ].
	 *
	 * @param array $request Data retrieved from POST request.
	 *
	 * @return void
	 */
	public function handle_request( array $request );

	/**
	 * Returns valid data from Tab. Can be used after ::handle_request or ::set_data.
	 *
	 * @return array
	 */
	public function get_data(): array;
}
```

And then abstract implementation for most of these methods:

```php
abstract class FieldSettingsTab implements SettingsTab {
	/** @var FormWithFields */
	private $form;

	/**
	 * @return Field[]
	 */
	abstract protected function get_fields(): array;

	protected function get_form(): FormWithFields {
		if ( $this->form === null ) {
			$fields     = $this->get_fields();
			$this->form = new FormWithFields( $fields, static::get_tab_slug() );
		}

		return $this->form;
	}

	public function render( Renderer $renderer ) {
		return $this->get_form()->render_form( $renderer );
	}

	public function set_data( ContainerInterface $data ) {
		$this->get_form()->set_data( $data );
	}

	public function handle_request( array $request ) {
		$this->get_form()->handle_request( $request );
	}

	public function get_data(): array {
		return $this->get_form()->get_data();
	}
}
```

Then we can create a settings tab that looks like that:

```php
final class GeneralSettings extends FieldSettingsTab {
	protected function get_fields(): array {
		return [
			( new CheckboxField() )
				->set_label( __( 'Subscribe on checkout', 'some-text-domain' ) )
				->set_description( __( 'Ask customers to subscribe to your mailing list on checkout.',
					'some-text-domain' ) )
				->set_description_tip( __( 'Setup Mailchimp or other email service add-on first.',
					'some-text-domain' ) )
				->set_name( 'wc_settings_sm_subscribe_on_checkout' ),

			( new CheckboxField() )
				->set_label( __( 'Help Icon', 'some-text-domain' ) )
				->set_sublabel( __( 'Disable help icon', 'some-text-domain' ) )
				->set_description( __( 'Help icon shows only on pages with help articles and ability to ask for help. If you do not want the help icon to display, you can entirely disable it here.',
					'some-text-domain' ) )
				->set_name( 'disable_beacon' ),

			( new CheckboxField() )
				->set_label( __( 'Usage Data', 'some-text-domain' ) )
				->set_sublabel( __( 'Enable', 'some-text-domain' ) )
				->set_description( sprintf( __( 'Help us improve Application and allow us to collect insensitive plugin usage data, %sread more%s.',
					'some-text-domain' ), '<a href="' . TrackerNotices::USAGE_DATA_URL . '" target="_blank">',
					'</a>' ) )
				->set_name( 'wpdesk_tracker_agree' ),

			( new SubmitField() )
				->set_name( 'save' )
				->set_label( __( 'Save changes', 'some-text-domain' ) )
				->add_class( 'button-primary' )
		];
	}

	public static function get_tab_slug() {
		return 'general';
	}

	public function get_tab_name() {
		return __( 'General', 'text-domain' );
	}
}
```

Then class like that provides form load/save/render support for this abstraction can look like this:

```php
/**
 * Adds settings to the menu and manages how and what is shown on the settings page.
 */
final class Settings {
	/**
	 * Save POST tab data. Before render.
	 *
	 * @return void
	 */
	public function save_settings_action() {
		if ( isset( $_GET['page'] ) && $_GET['page'] !== self::$settings_slug ) {
			return;
		}
		$tab            = $this->get_active_tab();
		$data_container = self::get_settings_persistence( $tab::get_tab_slug() );
		if ( ! empty( $_POST ) && isset( $_POST[ $tab::get_tab_slug() ] ) ) {
			$tab->handle_request( $_POST[ $tab::get_tab_slug() ] );
			$this->save_tab_data( $tab, $data_container );

			new Notice( __( 'Your settings have been saved.', 'text-domain' ),
				Notice::NOTICE_TYPE_SUCCESS );
		} else {
			$tab->set_data( $data_container );
		}
	}

	/**
	 * @return void
	 */
	public function render_page_action() {
		$tab      = $this->get_active_tab();
		$renderer = $this->get_renderer();
		echo $renderer->render( 'menu', [
			'base_url'   => self::get_url(),
			'menu_items' => $this->get_tabs_menu_items(),
			'selected'   => $this->get_active_tab()->get_tab_slug()
		] );
		echo $tab->render( $renderer );
		echo $renderer->render( 'footer' );
	}

	private function get_active_tab(): SettingTab {
		$selected_tab = isset( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : null;
		$tabs         = $this->get_settings_tabs();
		if ( ! empty( $selected_tab ) && isset( $tabs[ $selected_tab ] ) ) {
			return $tabs[ $selected_tab ];
		}

		return reset( $tabs );
	}

	/**
	 * @return SettingsTab[]
	 */
	private function get_settings_tabs(): array {
		static $tabs = [];
		if ( empty( $tabs ) ) {
			$tabs = [
				GeneralSettings::get_tab_slug()   => new GeneralSettings(),
				SomeOtherSettings::get_tab_slug() => new SomeOtherSettings()
			];
		}

		return $tabs;
	}

	/**
	 * Returns writable container with saved settings.
	 *
	 * @param string $tab_slug Unique slug of a settings tab.
	 *
	 * @return PersistentContainer
	 */
	public static function get_settings_persistence( string $tab_slug ): PersistentContainer {
		return new WordpressOptionsContainer( 'some-settings-' . $tab_slug );
	}

	/**
	 * Save data from tab to persistent container.
	 */
	private function save_tab_data( SettingsTab $tab, PersistentContainer $container ) {
		$tab_data = $tab->get_data();
		array_walk( $tab_data, static function ( $value, $key ) use ( $container ) {
			if ( ! empty( $key ) ) {
				$container->set( $key, $value );
			}
		} );
	}

private function get_renderer(): \WPDesk\View\Renderer\Renderer {
	return new SimplePhpRenderer( new DefaultFormFieldResolver() );
}

### Tabbed forms

```php
use WPDesk\Forms\Field\TabField;
use WPDesk\Forms\Form\TabbedForm;

$general = ( new TabField( [ /* fields */ ] ) )
	->set_tab_id( 'general' )
	->set_label( __( 'General', 'text-domain' ) );

$advanced = ( new TabField( [ /* fields */ ] ) )
	->set_tab_id( 'advanced' )
	->set_label( __( 'Advanced', 'text-domain' ) );

$form = new TabbedForm( [ $general, $advanced ], 'my-form' );
$form->set_active_tab( sanitize_key( $_GET['tab'] ?? 'general' ) );
```

### Persisting form data

```php
use WPDesk\Forms\Persistence\FormPersistence;

$form = new FormWithFields( $fields, 'my-form' );
$persistence = FormPersistence::for_form( $form, $container );

if ( $_POST ) {
	$form->handle_request( $_POST['my-form'] ?? [] );
	if ( $form->is_valid() ) {
		$persistence->save_form( $form );
	}
}

$persistence->hydrate_form( $form );
```

### Rendering without HTML

```php
use WPDesk\Forms\Renderer\JsonSchemaRenderer;
use WPDesk\Forms\Renderer\WooSettingsRenderer;

$json_schema = ( new JsonSchemaRenderer() )->render_fields( $form, $form->get_data() );
$woo_settings = ( new WooSettingsRenderer() )->render_fields( $form, $form->get_data() );
```

	/**
	 * @return string[]
	 */
	private function get_tabs_menu_items(): array {
		$menu_items = [];

		foreach ( $this->get_settings_tabs() as $tab ) {
			$menu_items[ $tab::get_tab_slug() ] = $tab->get_tab_name();
		}

		return $menu_items;
	}
}
```
