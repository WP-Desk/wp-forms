<?php

namespace DropshippingXmlVendor\WPDesk\Forms\Field;

use DropshippingXmlVendor\WPDesk\Forms\Sanitizer\TextFieldSanitizer;
class InputNumberField extends \DropshippingXmlVendor\WPDesk\Forms\Field\BasicField
{
    public function __construct()
    {
        parent::__construct();
        $this->set_default_value('');
        $this->set_attribute('type', 'number');
    }
    public function get_sanitizer()
    {
        return new \DropshippingXmlVendor\WPDesk\Forms\Sanitizer\TextFieldSanitizer();
    }
    public function get_template_name()
    {
        return 'input-number';
    }
}
