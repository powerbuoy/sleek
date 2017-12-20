<?php
function sleek_acf ($params) {
	if (!function_exists('acf_add_local_field_group')) {
		return false;
	}

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

	# Add help text to admin for selected fields
	sleek_acf_add_help($params);

	# Make sure a key is set
	if (!(isset($params['key']) and !empty($params['key']))) {
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
					$flexFieldLayoutKey = 'field_' . $fieldGroupKey . '_' . $flexName . '_' . $fieldName;

					if (($fields = sleek_acf_include_field($fieldName, $flexFieldLayoutKey)) !== false) {
						# Create the layout group
						$flexFieldLayout = [
							'key' => $flexFieldLayoutKey,
							'name' => $flexFieldLayoutKey,
							'label' => sleek_acf_nice_name($fieldName),
							'sub_fields' => []
						];

						# Automatically add the layout/template field
						$flexFieldLayout['sub_fields'][] = [
							'key' => $flexFieldLayoutKey . '-template',
							'name' => 'template',
							'label' => __('Layout', 'sleek'),
							'instructions' => __('Select a different layout for this module to change its appearance on the website.', 'sleek'),
							'type' => 'select',
							'choices' => sleek_acf_get_field_templates($fieldName)
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

# Conver "field-name" to "Field name"
function sleek_acf_nice_name ($name) {
	return __(ucfirst(str_replace(['_', '-'], ' ', $name)), 'sleek');
}

# Convert "Field name" to "fieldname"
function sleek_acf_ugly_name ($name) {
	return strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
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

# Recursively inserts unique keys for every field that has a name
# https://stackoverflow.com/questions/42121349/recursively-insert-element-next-to-other-element-in-array
function sleek_acf_generate_keys ($definition, $prefix) {
	foreach ($definition as $k => $v) {
		if (is_array($v)) {
			$newPrefix = isset($definition['name']) ? $prefix . '_' . $definition['name'] : $prefix;
			$definition[$k] = sleek_acf_generate_keys($v, $newPrefix);
		}
		elseif ($k == 'name') {
			$definition['key'] = $prefix . '_' . $definition[$k];
		}
	}

	return $definition;
}

# Returns a list of templates available for a specific field group
# TODO: Should check parent theme templates and merge with child theme templates
function sleek_acf_get_field_templates ($fieldName) {
	$templates = [];
	$path = get_stylesheet_directory() . '/acf/' . $fieldName . '/';

	if (file_exists($path)) {
		$tmp = scandir($path);
		$tmp = array_diff($tmp, ['.', '..']); # Remove ./..

		foreach ($tmp as $t) {
			$templates[$fieldName . '/' . basename($t, '.php')] = ucfirst(str_replace(['-', '_'], ' ', basename($t, '.php')));
		}
	}

	return $templates;
}

/**
 * Renders ACF flexible content modules in the $where container
 */
function sleek_acf_render_modules ($where, $postId = null) {
	global $post;

	if (!function_exists('get_field')) {
		return '[ERROR: You need to activate Advanced Custom Fields]';
	}

	if ($modules = get_field('modules-' . $where, $postId)) {
		$i = 0;
		$templateCount = [];
		$moduleCount = [];

		foreach ($modules as $module) {
			$acfLayout = isset($module['acf_fc_layout']) ? $module['acf_fc_layout'] : 'N/A';
			$template = isset($module['template']) ? $module['template'] : 'default';

			# Keep track of how many times this module is included
			if (isset($moduleCount[$acfLayout])) {
				$moduleCount[$acfLayout]++;
			}
			else {
				$moduleCount[$acfLayout] = 1;
			}

			# Keep track of how many times this template is included
			if (isset($templateCount[$template])) {
				$templateCount[$template]++;
			}
			else {
				$templateCount[$template] = 1;
			}

			# Include the template
			if (locate_template('acf/' . $template . '.php')) {
				sleek_get_template_part('acf/' . $template, [
					'data' => $module,
					'count' => ++$i,
					'module_area' => $where,
					'template_count' => $templateCount[$template],
					'module_count' => $moduleCount[$acfLayout]
				]);
			}
			# Or dump data if template doesn't exist
			else {
				echo '<section>';
				echo '<h2>No template found: ' . $template . '</h2>';
				echo '<p><small>' . $acfLayout . '</small></p>';
				echo '<pre>';
				var_dump($module);
				echo '</pre>';
				echo '</section>';
			}
		}
	}
}

# Add shortcode to render modules [render_module module="hubspot-cta" hubspot-cta-id="abc-123"]
add_shortcode('render_module', function ($args) {
	$template = isset($args['template']) ? $args['template'] : 'default';

	if (isset($args['module']) and ($path = locate_template('acf/' . $args['module'] . '/' . $template . '.php'))) {
		return sleek_fetch($path, [
			'data' => $args
		]);
	}

	return '[Unable to locate module]';
});

/**
 * Collapse flexible content fields on page load
 * And hide template dropdowns if there's only one template
 */
add_action('acf/input/admin_head', function () {
	?>
	<script>
		(function ($) {
			$(window).load(function () {
				// Collapse all flexible content modules
				$('a[data-name="collapse-layout"]').filter(function () {
					return !$(this).parents('.-collapsed').length && !$(this).parents('.acf-clone').length;
				}).click();

				// Hide templates if only one
				$('div[data-name="template"]').filter(function () {
					return $(this).find('option').length < 2;
				}).hide();
			});
		})(jQuery);
	</script>
	<?php
});

/**
 * Add help text to admin
 */
function sleek_acf_add_help ($params) {
	if (is_admin() and isset($params['location']) and count($params['location']) and count($params['location'][0])) {
		add_action('current_screen', function () use ($params) {
			$screen = get_current_screen();
			$location = $params['location'][0][0];

			# The fields are added to the post type we're viewing
			if ($location['param'] == 'post_type' and $screen->post_type == $location['value'] and $screen->base == 'post') {
				$sections = [];

				foreach ($params['fields'] as $k => $v) {
					if (is_array($v)) {
						foreach ($v as $field) {
							$helpSection = sleek_acf_get_help_section($field);

							if ($helpSection) {
								$sections[] = $helpSection;
							}
						}
					}
					else {
						$helpSection = sleek_acf_get_help_section($v);

						if ($helpSection) {
							$sections[] = $helpSection;
						}
					}
				}

				if (count($sections)) {
					$screen->add_help_tab([
						'id' => 'sleek_help_' . $params['key'],
						'title' => $params['title'],
						'content' => implode('', $sections)
					]);
				}
			}
		});
	}
}

function sleek_acf_get_help_section ($field) {
	if ($path = locate_template('acf/' . basename($field) . '.php')) {
		$content = file_get_contents($path);

		preg_match('/\/\*\*\*(.*?)\*\*\*\//s', $content, $matches);

		if (count($matches) > 1) {
			$helpText = '<strong>' . sleek_acf_nice_name($field) . '</strong> — ';
			$helpText .= trim($matches[1]);

			return wpautop($helpText);
		}

		return false;
	}

	return false;
}