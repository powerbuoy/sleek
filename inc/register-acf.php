<?php
/**
 * Inserts ACF into post types, $locations should be an array like:
 * [
 *	 'page' => ['page-meta', 'redirect-url', 'text-content'],
 *	 'movie' => ['redirect-url']
 * ]
 */
function sleek_register_acf ($locations, $textdomain = 'sleek') {
	# Go through every post type
	foreach ($locations as $pt => $fieldGroups) {
		# Create a title based on the post-type (knowledge_base => Knowledge base)
		$mainTitle = __(ucfirst(str_replace(['_', '-'], ' ', $pt)), $textdomain);

		# Create the main key for this group
		$mainKey = 'group_' . $pt;

		# Create the group definition, we will fill it with the fields later
		$definition = [
			'key' => $mainKey,
			'title' => $mainTitle,
			'fields' => [], # These will be populated below
			'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => $pt]]]
		];

		# Now go through all the field groups (video, page-options, etc)
		foreach ($fieldGroups as $fg) {
			# Make sure the field definition exists
			if ($path = locate_template('acf/' . basename($fg) . '.php')) {
				# Create the field group title
				$groupTitle = __(ucfirst(str_replace(['_', '-'], ' ', $fg)), $textdomain);

				# Add a tab
				$definition['fields'][] = [
					'key' => $mainKey . '_' . $fg . '_tab',
					'label' => $groupTitle,
					'type' => 'tab'
				];

				# Now get all the fields from the definition file
				$fgFields = include $path;

				# Automatically generate unique keys
				$fgFields = sleek_generate_unique_keys($fgFields, $mainKey);

				# Now go through all the fields in the definition file and add them to the group
				foreach ($fgFields as $f) {
					$definition['fields'][] = $f;
				}
			}
		}

		# Now that every field group is added (with a preceding tab), create the entire definition
		acf_add_local_field_group($definition);
	}
}

/**
 * Inserts ACF into "module areas" in post types, $locations should be an array like:
 * [
 * 	'page' => [
 * 		'below-content' => ['video', 'buttons', 'text-content'],
 * 		'above-content' => ['video']
 * 	],
 *  'movie' => [
 * 		'right-of-content' => ['video'],
 * 		'above-content' => ['video', 'buttons', 'text-content']
 * 	]
 * ]
 */
function sleek_register_acf_modules ($locations, $textdomain = 'sleek') {
	# Go through every post type
	foreach ($locations as $pt => $moduleGroups) {
		# Create a title
		$mainTitle = __('Modules', $textdomain);

		# Create the main key for this group
		$mainKey = 'group_' . $pt . '_modules';

		# Create the group definition, we will fill it with the fields later
		$definition = [
			'key' => $mainKey,
			'title' => $mainTitle,
			'fields' => [], # These will be populated below
			'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => $pt]]]
		];

		# Now go through all the "module groups" (Before Content, Inside Hero etc)
		foreach ($moduleGroups as $mg => $fieldGroups) {
			# Create the module group title
			$mgTitle = __(ucfirst(str_replace(['_', '-'], ' ', $mg)), $textdomain);

			# Create a tab for this module group
			$definition['fields'][] = [
				'key' => $mainKey . '_' . $mg . '_tab',
				'label' => $mgTitle,
				'type' => 'tab'
			];

			# Create the flexible content field
			$flexField = [
				'key' => $mainKey . '_' . $mg . '_modules',
				'name' => 'modules-' . $mg,
			#	'label' => __('Modules', 'sleek'),
			#	'instructions' => __('Add any number of modules here', 'sleek'),
				'button_label' => __('Add a module', 'sleek'),
				'type' => 'flexible_content',
				'layouts' => []
			];

			# Now go through all the field groups (video, page-options, etc)
			foreach ($fieldGroups as $fg) {
				# Make sure the field definition exists
				if ($path = locate_template('acf/' . basename($fg) . '.php')) {
					# Create the layout group group title
					$lgTitle = __(ucfirst(str_replace(['_', '-'], ' ', $fg)), $textdomain);

					# Create the layout group key
					$lgKey = $mainKey . '_' . $mg . '_' . $fg;

					# Create the layout group
					$flexFieldLayout = [
						'key' => $lgKey,
						'name' => $lgKey,
						'label' => $lgTitle,
						'sub_fields' => [
							# Automatically add the layout/template field
							[
								'key' => $lgKey . '-template',
								'name' => 'template',
								'label' => __('Layout', $textdomain),
								'instructions' => __('Select a different layout for this module to change its appearance on the website.', 'sleek'),
								'type' => 'select',
								'choices' => sleek_get_acf_group_templates($fg)
							]
						]
					];

					# Now get all the fields from the definition file
					$fgFields = include $path;

					# Automatically generate unique keys
					$fgFields = sleek_generate_unique_keys($fgFields, $lgKey);

					# Now go through all the fields in the definition file and add them to the group
					foreach ($fgFields as $f) {
						$flexFieldLayout['sub_fields'][] = $f;
					}
				}

				$flexField['layouts'][] = $flexFieldLayout;
			}

			$definition['fields'][] = $flexField;
		}

		acf_add_local_field_group($definition);
	}
}

# Registers ACF on options pages, automatically creates tabs if multiple fields are inserted
function sleek_register_acf_options ($locations, $textdomain = 'sleek') {
	# Go through every post type
	foreach ($locations as $pt => $fieldGroups) {
		# Create a title based on the post-type (knowledge_base => Knowledge base)
		$mainTitle = __(ucfirst(str_replace(['_', '-'], ' ', $pt)), $textdomain);

		# Create the main key for this group
		$mainKey = 'group_' . $pt;

		# Add the options page
		acf_add_options_page([
			'page_title' => $mainTitle,
			'menu_slug' => 'acf-options-' . $pt
		]);

		# Create the group definition, we will fill it with the fields later
		$definition = [
			'key' => $mainKey,
			'title' => $mainTitle,
			'fields' => [], # These will be populated below
			'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-' . $pt]]]
		];

		# Now go through all the field groups (video, page-options, etc)
		foreach ($fieldGroups as $fg) {
			# Make sure the field definition exists
			if ($path = locate_template('acf/' . basename($fg) . '.php')) {
				# Create the field group title
				$groupTitle = __(ucfirst(str_replace(['_', '-'], ' ', $fg)), $textdomain);

				# Add a tab
				$definition['fields'][] = [
					'key' => $mainKey . '_' . $fg . '_tab',
					'label' => $groupTitle,
					'type' => 'tab'
				];

				# Now get all the fields from the definition file
				$fgFields = include $path;

				# Automatically generate unique keys
				$fgFields = sleek_generate_unique_keys($fgFields, $mainKey);

				# Now go through all the fields in the definition file and add them to the group
				foreach ($fgFields as $f) {
					$definition['fields'][] = $f;
				}
			}
		}

		# Now that every field group is added (with a preceding tab), create the entire definition
		acf_add_local_field_group($definition);
	}
}

# Recursively inserts unique keys for every field that has a name
function sleek_generate_unique_keys ($definition, $prefix) {
	foreach ($definition as $k => $v) {
		if (is_array($v)) {
			$newPrefix = isset($definition['name']) ? $prefix . '_' . $definition['name'] : $prefix;
			$definition[$k]= sleek_generate_unique_keys($v, $newPrefix);
		}
		elseif ($k == 'name') {
			$definition['key'] = $prefix . '_' . $definition[$k];
		}
	}

	return $definition;
}

# Returns a list of templates available for a specific field group
function sleek_get_acf_group_templates ($acfGroup) {
	$path = get_stylesheet_directory() . '/acf/' . $acfGroup . '/';
	$templates = [];

	if (file_exists($path)) {
		$tmp = scandir($path);
		$tmp = array_diff($tmp, ['.', '..']); # Remove ./.. and "main" template

		foreach ($tmp as $t) {
			if (substr(basename($t), 0, 2) != '__' and substr(basename($t), 0, 1) != '.') {
				$templates[$acfGroup . '/' . basename($t, '.php')] = ucfirst(str_replace(['-', '_'], ' ', basename($t, '.php')));
			}
		}
	}

	return $templates;
}

# Nicer Flexible Content Titles (https://www.advancedcustomfields.com/resources/acf-fields-flexible_content-layout_title/)
add_filter('acf/fields/flexible_content/layout_title', function ($title, $field, $layout, $i) {
	# Figure out the field name
	$nameBits = explode('_', $layout['name']);
	$fieldName = end($nameBits);
	$newTitle = '<strong>' . $title . '</strong>';

	# See if it has a title
	if ($t = get_sub_field($fieldName . '-title')) {
		$newTitle .= ": \"$t\"";
	}

	# Or template
	if ($t = get_sub_field($layout['key'] . '-template')) {
		$newTitle .= ' <small>(' . ucfirst(str_replace(['-', '_'], ' ', basename($t, '.php'))) . ' layout)</small>';
	}

	return $newTitle;
}, 10, 4);
