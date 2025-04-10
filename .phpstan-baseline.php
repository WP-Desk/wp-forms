<?php declare(strict_types = 1);

$ignoreErrors = [];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Field\\\\BasicField\\:\\:get_type\\(\\) should return string but returns mixed\\.$#',
	'identifier' => 'return.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Field\\\\BasicField\\:\\:unset_attribute\\(\\) has invalid return type WPDesk\\\\Forms\\\\Field\\\\Traits\\\\HtmlAttributes\\.$#',
	'identifier' => 'return.trait',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Field\\\\BasicField\\:\\:unset_attribute\\(\\) should return WPDesk\\\\Forms\\\\Field\\\\Traits\\\\HtmlAttributes but returns \\$this\\(WPDesk\\\\Forms\\\\Field\\\\BasicField\\)\\.$#',
	'identifier' => 'return.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'class\' on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\} on left side of \\?\\? always exists and is not nullable\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'data\' on array\\{default_value\\: string, possible_values\\?\\: array\\<string\\>, sublabel\\?\\: string, priority\\: int, label\\: string, description\\: string, description_tip\\: string, data\\: array\\<int\\|string\\>\\} on left side of \\?\\? always exists and is not nullable\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'default_value\' on array\\{default_value\\: string, possible_values\\?\\: array\\<string\\>, sublabel\\?\\: string, priority\\: int, label\\: string, description\\: string, description_tip\\: string, data\\: array\\<int\\|string\\>\\} on left side of \\?\\? always exists and is not nullable\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'description\' on array\\{default_value\\: string, possible_values\\?\\: array\\<string\\>, sublabel\\?\\: string, priority\\: int, label\\: string, description\\: string, description_tip\\: string, data\\: array\\<int\\|string\\>\\} on left side of \\?\\? always exists and is not nullable\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'description_tip\' on array\\{default_value\\: string, possible_values\\?\\: array\\<string\\>, sublabel\\?\\: string, priority\\: int, label\\: string, description\\: string, description_tip\\: string, data\\: array\\<int\\|string\\>\\} on left side of \\?\\? always exists and is not nullable\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'disabled\' on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\} on left side of \\?\\? does not exist\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'id\' on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\} on left side of \\?\\? always exists and is not nullable\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'label\' on array\\{default_value\\: string, possible_values\\?\\: array\\<string\\>, sublabel\\?\\: string, priority\\: int, label\\: string, description\\: string, description_tip\\: string, data\\: array\\<int\\|string\\>\\} on left side of \\?\\? always exists and is not nullable\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'multiple\' on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\} in isset\\(\\) does not exist\\.$#',
	'identifier' => 'isset.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'name\' on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\} on left side of \\?\\? always exists and is not nullable\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'placeholder\' on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\} on left side of \\?\\? always exists and is not nullable\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'readonly\' on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\} on left side of \\?\\? does not exist\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'required\' on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\} in isset\\(\\) does not exist\\.$#',
	'identifier' => 'isset.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'type\' does not exist on array\\{default_value\\: string, possible_values\\?\\: array\\<string\\>, sublabel\\?\\: string, priority\\: int, label\\: string, description\\: string, description_tip\\: string, data\\: array\\<int\\|string\\>\\}\\.$#',
	'identifier' => 'offsetAccess.notFound',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset string on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\} on left side of \\?\\? always exists and is not nullable\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Property WPDesk\\\\Forms\\\\Field\\\\BasicField\\:\\:\\$attributes \\(array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\}\\) does not accept array\\{placeholder\\?\\: string, name\\?\\: string, id\\?\\: string, class\\?\\: array\\<string\\>\\}\\.$#',
	'identifier' => 'assign.propertyType',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Property WPDesk\\\\Forms\\\\Field\\\\BasicField\\:\\:\\$attributes \\(array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\}\\) does not accept default value of type array\\{\\}\\.$#',
	'identifier' => 'property.defaultValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Property WPDesk\\\\Forms\\\\Field\\\\BasicField\\:\\:\\$attributes \\(array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\}\\) does not accept non\\-empty\\-array\\<string, array\\<string\\>\\|bool\\|string\\>\\.$#',
	'identifier' => 'assign.propertyType',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Return type \\(array\\<array\\<string\\>\\|bool\\|string\\>\\) of method WPDesk\\\\Forms\\\\Field\\\\BasicField\\:\\:get_attributes\\(\\) should be covariant with return type \\(array\\<string\\>\\) of method WPDesk\\\\Forms\\\\Field\\:\\:get_attributes\\(\\)$#',
	'identifier' => 'method.childReturnType',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/BasicField.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'sublabel\' might not exist on array\\{default_value\\: string, possible_values\\?\\: array\\<string\\>, sublabel\\?\\: string, priority\\: int, label\\: string, description\\: string, description_tip\\: string, data\\: array\\<int\\|string\\>\\}\\.$#',
	'identifier' => 'offsetAccess.notFound',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/CheckboxField.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$action of class WPDesk\\\\Forms\\\\Validator\\\\NonceValidator constructor expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Field/NoOnceField.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\FieldRenderer\\:\\:render_fields\\(\\) has parameter \\$fields_data with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/FieldRenderer.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\FieldRenderer\\:\\:render_fields\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/FieldRenderer.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Form\\:\\:get_normalized_data\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Form.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Form\\:\\:handle_request\\(\\) has parameter \\$request with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Form.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\:\\:get_action\\(\\) should return string but returns mixed\\.$#',
	'identifier' => 'return.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\:\\:get_data\\(\\) should return array\\<int\\|string\\> but returns array\\.$#',
	'identifier' => 'return.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\:\\:get_method\\(\\) should return string but returns mixed\\.$#',
	'identifier' => 'return.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\:\\:get_normalized_data\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\:\\:handle_request\\(\\) has parameter \\$request with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\:\\:unset_attribute\\(\\) has invalid return type WPDesk\\\\Forms\\\\Field\\\\Traits\\\\HtmlAttributes\\.$#',
	'identifier' => 'return.trait',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\:\\:unset_attribute\\(\\) should return WPDesk\\\\Forms\\\\Field\\\\Traits\\\\HtmlAttributes but returns \\$this\\(WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\)\\.$#',
	'identifier' => 'return.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'action\' does not exist on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\}\\.$#',
	'identifier' => 'offsetAccess.notFound',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset \'method\' does not exist on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\}\\.$#',
	'identifier' => 'offsetAccess.notFound',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Offset string on array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\} on left side of \\?\\? always exists and is not nullable\\.$#',
	'identifier' => 'nullCoalesce.offset',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#2 \\$value of method WPDesk\\\\Persistence\\\\PersistentContainer\\:\\:set\\(\\) expects array\\|float\\|int\\|string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 2,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Property WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\:\\:\\$attributes \\(array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\}\\) does not accept array\\{placeholder\\?\\: string, name\\?\\: string, id\\?\\: string, class\\?\\: array\\<string\\>\\}\\.$#',
	'identifier' => 'assign.propertyType',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Property WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\:\\:\\$attributes \\(array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\}\\) does not accept default value of type array\\{\\}\\.$#',
	'identifier' => 'property.defaultValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Property WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\:\\:\\$attributes \\(array\\{placeholder\\: string, name\\: string, id\\: string, class\\: array\\<string\\>\\}\\) does not accept non\\-empty\\-array\\<string, array\\<string\\>\\|bool\\|string\\>\\.$#',
	'identifier' => 'assign.propertyType',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Property WPDesk\\\\Forms\\\\Form\\\\FormWithFields\\:\\:\\$updated_data type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Form/FormWithFields.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Persistence\\\\FieldPersistenceStrategy\\:\\:load_fields\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Persistence/FieldPersistenceStrategy.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Persistence\\\\FieldPersistenceStrategy\\:\\:persist_fields\\(\\) has parameter \\$data with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Persistence/FieldPersistenceStrategy.php',
];
$ignoreErrors[] = [
	'message' => '#^PHPDoc tag @return with type void is incompatible with native type array\\.$#',
	'identifier' => 'return.phpDocType',
	'count' => 1,
	'path' => __DIR__ . '/src/Persistence/FieldPersistenceStrategy.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$value of method WPDesk\\\\Forms\\\\Serializer\\:\\:unserialize\\(\\) expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Persistence/FieldPersistenceStrategy.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#2 \\$value of method WPDesk\\\\Persistence\\\\PersistentContainer\\:\\:set\\(\\) expects array\\|float\\|int\\|string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Persistence/FieldPersistenceStrategy.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Renderer\\\\JsonNormalizedRenderer\\:\\:render_fields\\(\\) has parameter \\$fields_data with no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Renderer/JsonNormalizedRenderer.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Renderer\\\\JsonNormalizedRenderer\\:\\:render_fields\\(\\) return type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Renderer/JsonNormalizedRenderer.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Sanitizer\\\\CallableSanitizer\\:\\:sanitize\\(\\) should return string but returns mixed\\.$#',
	'identifier' => 'return.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Sanitizer/CallableSanitizer.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$email of function sanitize_email expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Sanitizer/EmailSanitizer.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$callback of function array_map expects \\(callable\\(mixed\\)\\: mixed\\)\\|null, \'sanitize_text_field\' given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Sanitizer/TextFieldSanitizer.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$str of function sanitize_text_field expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Sanitizer/TextFieldSanitizer.php',
];
$ignoreErrors[] = [
	'message' => '#^Method WPDesk\\\\Forms\\\\Validator\\\\ChainValidator\\:\\:get_messages\\(\\) should return array\\<string\\> but returns array\\.$#',
	'identifier' => 'return.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Validator/ChainValidator.php',
];
$ignoreErrors[] = [
	'message' => '#^Property WPDesk\\\\Forms\\\\Validator\\\\ChainValidator\\:\\:\\$messages type has no value type specified in iterable type array\\.$#',
	'identifier' => 'missingType.iterableValue',
	'count' => 1,
	'path' => __DIR__ . '/src/Validator/ChainValidator.php',
];
$ignoreErrors[] = [
	'message' => '#^Parameter \\#1 \\$nonce of function wp_verify_nonce expects string, mixed given\\.$#',
	'identifier' => 'argument.type',
	'count' => 1,
	'path' => __DIR__ . '/src/Validator/NonceValidator.php',
];

return ['parameters' => ['ignoreErrors' => $ignoreErrors]];
