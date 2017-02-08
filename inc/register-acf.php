<?php
# Registers ACF on post types, automatically creates tabs if multiple fields are inserted
function sleek_register_acf ($locations, $textdomain = 'sleek') {
	if (!function_exists('acf_add_local_field_group')) {
		return false;
	}

	foreach ($locations as $slug => $groups) {
		$title = __(ucfirst(str_replace(['_', '-'], ' ', $slug)), $textdomain);
		$key = 'group_' . $slug;

		# Create this PT's group definition
		$definition = [
			'key' => $key,
			'name' => $key,
			'title' => $title,
			'label' => $title,
			'position' => 'normal',
			'fields' => [],
			'location' => [
				[
					[
						'param' => 'post_type',
						'operator' => '==',
						'value' => $slug
					]
				]
			]
		];

		# Go through every field group
		foreach ($groups as $group) {
			$path = 'acf/' . basename($group) . '.php';
			$absPath = locate_template($path);

			# If we found it
			if ($absPath) {
				# Create a title for this field group (for the tab)
				$groupTitle = __(ucfirst(str_replace(['_', '-'], ' ', $group)), $textdomain);

				# Add a tab
				$definition['fields'][] = [
					'key' => $key . '_' . $group . '_tab',
					'label' => $groupTitle,
					'type' => 'tab'
				];

				# Get all the fields from the definition file
				$fields = include $absPath;

				# Add all the fields in the group
				for ($i = 0; $i < count($fields); $i++) {
					$definition['fields'][] = $fields[$i];
				}
			}
		}

		acf_add_local_field_group($definition);
	}
}

# Registers ACF on options pages, automatically creates tabs if multiple fields are inserted
function sleek_register_acf_options ($locations, $textdomain = 'sleek') {
	if (!function_exists('acf_add_local_field_group')) {
		return false;
	}

	foreach ($locations as $slug => $groups) {
		acf_add_options_page(ucfirst(str_replace(['_', '-'], ' ', $slug))); # Mustn't be translated as it changes the slug

		$title = __(ucfirst(str_replace(['_', '-'], ' ', $slug)), $textdomain);
		$key = 'group_' . $slug;

		# Create this PT's group definition
		$definition = [
			'key' => $key,
			'name' => $key,
			'title' => $title,
			'label' => $title,
			'position' => 'normal',
			'fields' => [],
			'location' => [
				[
					[
						'param' => 'options_page',
						'operator' => '==',
						'value' => 'acf-options-' . $slug
					]
				]
			]
		];

		# Go through every field group
		foreach ($groups as $group) {
			$path = 'acf/' . basename($group) . '.php';
			$absPath = locate_template($path);

			# If we found it
			if ($absPath) {
				# Create a title for this field group (for the tab)
				$groupTitle = __(ucfirst(str_replace(['_', '-'], ' ', $group)), $textdomain);

				# Add a tab
				$definition['fields'][] = [
					'key' => 'field_' . $key . '_' . $group . '_tab',
					'label' => $groupTitle,
					'type' => 'tab'
				];

				# Get all the fields from the definition file
				$fields = include $absPath;

				# Add all the fields in the group
				for ($i = 0; $i < count($fields); $i++) {
					$definition['fields'][] = $fields[$i];
				}
			}
		}

		acf_add_local_field_group($definition);
	}
}

# Registers ACF on module groups, automatically creates tabs between module groups
function sleek_register_acf_modules ($locations, $textdomain = 'sleek') {
	if (!function_exists('acf_add_local_field_group')) {
		return false;
	}

	foreach ($locations as $slug => $moduleGroups) {
		$title = __('Modules', $textdomain);
		$key = 'group_modules';

		$definition = [
			'key' => $key,
			'name' => $key,
			'title' => $title,
			'label' => $title,
			'position' => 'normal',
			'fields' => [],
			'location' => [
				[
					[
						'param' => 'post_type',
						'operator' => '==',
						'value' => $slug
					]
				]
			]
		];

		foreach ($moduleGroups as $mg => $groups) {
			# Module group title
			$mgTitle = __(ucfirst(str_replace(['_', '-'], ' ', $mg)), $textdomain);

			# Create a tab for this module group
			$definition['fields'][] = [
				'key' => 'field_' . $key . '-modules-' . $mg . '_tab',
				'label' => $mgTitle,
				'type' => 'tab'
			];

			# Create the flexible content field
			$flexField = [
				'key' => 'field_' . $key . '-modules-' . $mg,
				'name' => 'modules-' . $mg,
				'label' => __('Modules', 'sleek'),
				'button_label' => __('Add a module', 'sleek'),
				'type' => 'flexible_content',
				'layouts' => []
			];

			# Add all the fields
			foreach ($groups as $group) {
				$path = 'acf/' . basename($group) . '.php';
				$absPath = locate_template($path);

				# If we found it
				if ($absPath) {
					# Create a title for this field group
					$groupTitle = __(ucfirst(str_replace(['_', '-'], ' ', $group)), $textdomain);
					$groupKey = 'group_modules-' . $mg . '-' . $group;

					# Create the layout group
					$flexFieldLayout = [
						'key' => $groupKey,
						'name' => $groupKey,
						'title' => $groupTitle,
						'label' => $groupTitle,
						'sub_fields' => [
							# Automatically add the layout/template field
							[
								'key' => 'field_' . $groupKey . '-template',
								'name' => 'template',
								'label' => __('Layout', $textdomain),
								'type' => 'select',
								'choices' => sleek_get_acf_group_templates($group)
							]
						]
					];

					# Create a title for this field group (for the tab)
					$groupTitle = __(ucfirst(str_replace(['_', '-'], ' ', $group)), $textdomain);

					# Get all the fields from the definition file
					$fields = include $absPath;

					# Add all the fields
					for ($i = 0; $i < count($fields); $i++) {
						$flexFieldLayout['sub_fields'][] = $fields[$i];
					}
				}

				$flexField['layouts'][] = $flexFieldLayout;
			}

			$definition['fields'][] = $flexField;
		}

		acf_add_local_field_group($definition);
	}
}

function sleek_get_acf_group_templates ($acfGroup) {
	$tmp = scandir(get_stylesheet_directory() . '/acf/' . $acfGroup . '/');
	$tmp = array_diff($tmp, ['.', '..']); # Remove ./.. and "main" template
	$templates = [];

	foreach ($tmp as $t) {
		if (substr(basename($t), 0, 2) != '__') {
			$templates[$acfGroup . '/' . basename($t, '.php')] = ucfirst(str_replace(['-', '_'], ' ', basename($t, '.php')));
		}
	}

	return $templates;
}

# TODO
function sleek_generate_unique_keys ($definition) {
	$newDefinition = $definition;

	return $newDefinition;
}

# Nicer Flexible Content Titles (https://www.advancedcustomfields.com/resources/acf-fields-flexible_content-layout_title/)
add_filter('acf/fields/flexible_content/layout_title', function ($title, $field, $layout, $i) {
	$fieldName = strtolower(str_replace(' ', '-', $layout['label']));
	$newTitle = $title;

	if ($t = get_sub_field($fieldName . '-title')) {
		$newTitle .= ": \"$t\"";
	}

	if ($t = get_sub_field('field_' . $layout['key'] . '-template')) {
		$newTitle .= ' (' . ucfirst(str_replace(['-', '_'], ' ', basename($t, '.php'))) . ')';
	}

	return $newTitle;
}, 10, 4);
