<?php
function sleek_acf ($params) {
	# Some sensible defaults
	$defaults = [
		'title' => __('Untitled', 'sleek'),
		'position' => 'normal',
		'style' => 'normal',
		'flexible' => false,
		'location' => [[[
			'param' => 'post_type',
			'operator' => '==',
			'value' => 'page'
		]]]
	];

	# Merge user's params with our defaults
	$params = array_merge($defaults, $params);

	# Make sure a key is set
	if ((isset($params['key']) and !empty($params['key']))) {
		return false;
	}

	$fieldGroupKey = $params['key'] = 'group_' . $params['key'];

	# Remember whether this group should be a flexible content group
	$isFlexible = (isset($params['flexible']) and $params['flexible'] == true) ? true : false;

	# Make sure user has defined some fields - if not tell him
	if (!(isset($params['fields']) and count($params['fields']))) {
		$params['fields'] = [
			[
				'key' => 'field_' . $fieldGroupKey . '_message_field',
				'type' => 'message',
				'label' => __('Add some fields', 'sleek'),
				'message' => __('You have not added any fields to your field group.', 'sleek')
			]
		];
	}
	# User has defined a list of fields and asked for them to be flexible - create flexible content groups
	elseif ($isFlexible) {
		$newFields = [];

		foreach ($params['fields'] as $flexName => $fields) {
			# Make sure $fields is an array - else do nothing
			if (is_array($fields)) {
				# Create a tab for this flex group
				$newFields[] = [
					'key' => 'field_' . $fieldGroupKey . '_tab_' . $flexName,
					'label' => sleek_acf_nice_name($flexName),
					'type' => 'tab'
				];

				# Create the flexible content field
				$flexField = [
					'key' => 'field_' . $fieldGroupKey . '_' . $flexName . '_modules',
					'name' => 'modules-' . $flexName,
					'button_label' => __('Add a module', 'sleek'),
					'type' => 'flexible_content',
					'layouts' => []
				];

				# Now go through all the fields and add them to the flex field
				foreach ($fields as $fieldName) {
					if ($fields = sleek_acf_include_field($fieldName, $fieldGroupKey)) {
						$flexFieldLayoutKey = 'field_' . $fieldGroupKey . '_' . $flexName . '_' . $fieldName;

						# Create the layout group
						$flexFieldLayout = [
							'key' => $flexFieldLayoutKey,
							'name' => $flexFieldLayoutKey,
							'label' => sleek_acf_nice_name($fieldName),
							'sub_fields' => [
								# Automatically add the layout/template field
								[
									'key' => $flexFieldLayoutKey . '-template',
									'name' => 'template',
									'label' => __('Layout', 'sleek'),
									'instructions' => __('Select a different layout for this module to change its appearance on the website.', 'sleek'),
									'type' => 'select',
									'choices' => sleek_acf_get_field_templates($fieldName)
								]
							]
						];

						# Finally add the rest of the fields
						$flexFieldLayout['sub_fields'] = array_merge($flexFieldLayout['sub_fields'], $fields);
					}

					$flexField['layouts'][] = $flexFieldLayout;
				}

				$newFields[] = $flexField;
				$params['fields'] = $newFields;
			}
		}
	}
	# User has defined a list of fields - create a real field definition from them
	else {
		$newFields = [];

		# Loop through every field
		foreach ($params['fields'] as $key => $value) {
			# If the field itself is an array - create tabs
			if (is_array($value)) {
				$newFields[] = [
					'key' => 'field_' . $fieldGroupKey . '_tab' . sleek_acf_ugly_name($key),
					'label' => $key,
					'type' => 'tab'
				];

				foreach ($value as $fieldName) {
					# Include field group definition and merge with previous fields
					if ($fields = sleek_acf_include_field($fieldName, 'field_' . $fieldGroupKey)) {
						$newFields = array_merge($newFields, $fields);
					}
				}
			}
			# Not an array - just add the fields without tabs
			else {
				# Include field group definition and merge with previous fields
				if ($fields = sleek_acf_include_field($value, $fieldGroupKey)) {
					$newFields = array_merge($newFields, $fields);
				}
			}
		}

		$params['fields'] = $newFields;
	}

	# Now add our field group
	acf_add_local_field_group($params);
}

# Conver a "field-name" to "Field name"
function sleek_acf_nice_name ($name) {
	return __(ucfirst(str_replace(['_', '-'], ' ', $name)), 'sleek');
}

# Convert a "Field name" to "fieldname"
# https://stackoverflow.com/questions/12339942/sanitize-strings-for-legal-variable-names-in-php
function sleek_acf_ugly_name ($name) {
	return strtolower(preg_replace('/[^a-zA-Z0-9]/', '', (string) $name));
}

# Includes a field definition located in acf/field-name.php and gives it unique keys
function sleek_acf_include_field ($fieldName, $keyPrefix) {
	$fieldGroup = false;

	if ($path = locate_template('acf/' . basename($fieldName) . '.php')) {
		$fieldGroup = include $path;
		$fieldGroup = sleek_acf_generate_keys($fieldGroup, $keyPrefix);
	}

	return $fieldGroup;
}

# Returns a list of templates available for a specific field group
# TODO: Should check parent theme templates and merge with child theme templates
function sleek_acf_get_field_templates ($fieldName) {
	$templates = [];
	$path = get_stylesheet_directory() . '/acf/' . $fieldName . '/';

	if (file_exists($path)) {
		$tmp = scandir($path);
		$tmp = array_diff($tmp, ['.', '..']); # Remove ./.. and "main" template

		foreach ($tmp as $t) {
			if (substr(basename($t), 0, 2) != '__' and substr(basename($t), 0, 1) != '.') {
				$templates[$fieldName . '/' . basename($t, '.php')] = ucfirst(str_replace(['-', '_'], ' ', basename($t, '.php')));
			}
		}
	}

	return $templates;
}

# Recursively inserts unique keys for every field that has a name
# https://stackoverflow.com/questions/42121349/recursively-insert-element-next-to-other-element-in-array
function sleek_acf_generate_keys ($definition, $prefix) {
	foreach ($definition as $k => $v) {
		if (is_array($v)) {
			$newPrefix = isset($definition['name']) ? $prefix . '_' . $definition['name'] : $prefix;
			$definition[$k]= sleek_acf_generate_keys($v, $newPrefix);
		}
		elseif ($k == 'name') {
			$definition['key'] = $prefix . '_' . $definition[$k];
		}
	}

	return $definition;
}
