<?php
class SleekACF {
	################
	# Hook upp stuff
	public static function init () {
		self::collapseFields();
		self::niceFlexTitles();
		self::cleanTaxPage();
	}

	private static function niceName ($name) {
		return __(ucfirst(str_replace(['_', '-'], ' ', $name)), 'sleek');
	}

	private static function uglyName ($name) {
		return strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
	}

	public static function hasFlexibleModule ($module, $areas, $postId = null) {
		$hasIn = [];

		foreach ($areas as $area) {
			if ($modules = get_field('modules_' . $area, $postId)) {
				foreach ($modules as $mod) {
					$template = $mod['template'] ?? null;

					if ($template and $templateParts = explode('/', $template)) {
						$moduleName = $templateParts[0];

						if ($moduleName === $module) {
							$hasIn[] = $area;
						}
					}
				}
			}
		}

		return $hasIn ?? false;
	}

	################################################
	# Hide taxonomy fields on the main taxonomy page
	# https://support.advancedcustomfields.com/forums/topic/hide-taxonomy-term-fields-on-the-main-category-page/
	private static function cleanTaxPage () {
		add_filter('acf/location/rule_match/taxonomy', function ($match, $rule, $options) {
			if ($rule['param'] === 'taxonomy' and !isset($_GET['tag_ID'])) {
				return false;
			}

			return $match;
		}, 20, 3);
	}

	##############################
	# Nice flexible content titles
	private static function niceFlexTitles () {
		add_filter('acf/fields/flexible_content/layout_title', function ($title, $field, $layout, $i) {
			# Figure out the field name
			$nameBits = explode('_', $layout['name']);
			$fieldName = end($nameBits);
			$fieldName = str_replace('-', '_', $fieldName);
			$newTitle = '<strong>' . $title . '</strong>';

			# See if it has a "title" field
			if ($t = get_sub_field($fieldName . '_title')) {
				$newTitle .= strip_tags(": \"$t\"");
			}

			# Or template
			if ($t = get_sub_field($layout['key'] . '_template')) {
				if ($t === 'SLEEK_ACF_HIDDEN_TEMPLATE') {
					$newTitle .= '(' . __('Hidden', 'sleek') . ')';
				}
				else {
					$newTitle .= ' (' . sprintf(__('Template: "%s"', 'sleek'), __(ucfirst(str_replace(['-', '_'], ' ', basename($t, '.php')))), 'sleek') . ')';
				}
			}

			return $newTitle;
		}, 10, 4);
	}

	###############################################
	# Collapse flexible content fields on page load
	# And hide template dropdowns if there's only one template
	private static function collapseFields () {
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
	}

	########################################################
	# Adds ACF options pages that are translatable with WPML
	public static function addOptionsPage ($args) {
		if (!function_exists('acf_add_options_page')) {
			throw new Exception('The function acf_add_options_page() does not exist. Please install the ACF Pro plugin.');
		}

		acf_add_options_page($args);

		# Make options pages translatable
		if (isset($args['post_id'])) {
			add_filter('acf/validate_post_id', function ($postId) use ($args) {
				if ($postId == $args['post_id']) {
					$dl = acf_get_setting('default_language');
					$cl = acf_get_setting('current_language');

					if ($cl and $cl !== $dl) {
						$postId .= '_' . $cl;
					}
				}

				return $postId;
			});
		}
	}

	###############################################
	# Render flexible modules in module area $where
	public static function renderModules ($where, $postId = null) {
		global $post;

		if (!function_exists('get_field')) {
			throw new Exception('Function get_field() does not exist. Please install the ACF Pro plugin.');
		}

		if ($modules = get_field('modules_' . $where, $postId)) {
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

				# Ignore this module
				if ($template === 'SLEEK_ACF_HIDDEN_TEMPLATE') {
					echo '<!-- Module hidden: ' . $acfLayout . ' -->';
				}
				# Include the template
				elseif (locate_template('acf/' . $template . '.php')) {
					sleek_get_template_part('acf/' . $template, null, array_merge($module, [
						'sleek_acf_data' => [
							'count' => ++$i,
							'module_area' => $where,
							'template_count' => $templateCount[$template],
							'module_count' => $moduleCount[$acfLayout],
							'module_data' => $module
						]
					]));
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

	########################
	# Render a sticky module
	public static function renderStickyModule ($module, $postId = null, $template = 'default', $echo = true) {
		global $post;

		if (!function_exists('get_field')) {
			throw new Exception('The function get_field() does not exist. Please install the ACF Pro plugin.');
		}

		# Make sure config and template exist
		if (($configPath = locate_template('acf/' . $module . '/config.php')) and ($templatePath = locate_template('acf/' . $module . '/' . $template . '.php'))) {
			$fieldGroup = include $configPath;
			$moduleData = [];

			foreach ($fieldGroup as $field) {
				$moduleData[$field['name']] = get_field($field['name'], $postId);
			}

			$return = sleek_fetch_template_part('acf/' . $module . '/' . $template, $moduleData);
		}
		# No such module
		else {
			throw new Exception('Module ' . $module . ' with template ' . $template . ' does not exist.');
		}

		if ($echo) {
			echo $return;
		}

		return $return;
	}

	###################
	# Add a field group
	public static function addFieldGroup ($params) {
		# Make sure we have needed functions
		if (!function_exists('acf_add_local_field_group')) {
			throw new Exception('Function acf_add_local_field_group() does not exist. Please install the ACF Pro plug-in.');
		}

		# Sensible defaults
		$params = array_merge([
			'title' => __('Untitled', 'sleek'),
			'position' => 'normal',
			'style' => 'normal',
			'flexible' => false,
			'tab_placement' => 'top',
			'location' => [[[
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'page'
			]]]
		], $params);

		# Add help section
		self::addHelp($params);

		# Make sure mandatory fields are set
		if (!isset($params['key']) or empty($params['key'])) {
			throw new Exception('You need to specify a unique key for your field group: ' . $params['title']);
		}

		# Create group key (NOTE: according to ACF docs it _has_ to start with "group_" though this isn't actually true)
		$fieldGroupKey = $params['key'] = 'group_' . $params['key'];

		# Remember whether this group should be a flexible content group
		$isFlexible = (isset($params['flexible']) and $params['flexible'] !== false) ? true : false;
		$isHidable = (isset($params['hidable']) and $params['hidable'] !== false) ? true : false;

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
		# Flexible fields
		elseif ($isFlexible) {
			$params['fields'] = self::generateFlexibleFields($params['fields'], $fieldGroupKey, $params['tab_placement'], $isHidable);
		}
		# Sticky fields
		else {
			$params['fields'] = self::generateStickyFields($params['fields'], $fieldGroupKey, $params['tab_placement']);
		}

		# Now add our field group
		acf_add_local_field_group($params);
	}

	##################################
	# Generates a real ACF field group
	# from an array of field group names like ['latest-posts', 'text-block']
	private static function generateStickyFields ($fields, $groupKey, $tabPlacement = 'top') {
		$newFields = [];

		# Loop through every field
		foreach ($fields as $key => $value) {
			# If the field itself is an array - create tabs using the $key as the tab label
			if (is_array($value)) {
				$newFields[] = [
					'key' => 'field_' . $groupKey . '_tab' . self::uglyName($key),
					'label' => $key,
					'type' => 'tab',
					'placement' => $tabPlacement
				];

				foreach ($value as $fieldName) {
					# Include field group definition and merge with previous fields
					if ($fields = self::loadFieldDefinition($fieldName, 'field_' . $groupKey)) {
						$newFields = array_merge($newFields, $fields);
					}
				}
			}
			# Not an array - just add the fields without tabs
			else {
				# Include field group definition and merge with previous fields
				if ($fields = self::loadFieldDefinition($value, 'field_' . $groupKey)) {
					$newFields = array_merge($newFields, $fields);
				}
			}
		}

		return $newFields;
	}

	###########################################
	# Generates a real ACF flexible field group
	# from an array of field group names like ['latest-posts', 'text-block']
	private static function generateFlexibleFields ($flexFields, $groupKey, $tabPlacement = 'top', $isHidable = false) {
		$newFields = [];

		foreach ($flexFields as $flexName => $fields) {
			# Make sure $fields is an array - else do nothing
			if (is_array($fields)) {
				# Create a tab for this flex group
				$newFields[] = [
					'key' => 'field_' . $groupKey . '_tab_' . $flexName,
					'label' => self::niceName($flexName),
					'type' => 'tab',
					'placement' => $tabPlacement
				];

				# Create the flexible content field
				$flexField = [
					'key' => 'field_' . $groupKey . '_' . $flexName . '_modules',
					'name' => 'modules_' . $flexName,
					'button_label' => __('Add a module', 'sleek'),
					'type' => 'flexible_content',
					'layouts' => []
				];

				# Now go through all the fields and add them to the flex field
				foreach ($fields as $fieldName) {
					$flexFieldLayoutKey = 'field_' . $groupKey . '_' . $flexName . '_' . $fieldName;

					if (($fields = self::loadFieldDefinition($fieldName, $flexFieldLayoutKey)) !== false) {
						# Create the layout group
						$flexFieldLayout = [
							'key' => $flexFieldLayoutKey,
							'name' => $flexFieldLayoutKey,
							'label' => self::niceName($fieldName),
						#	'max' => 1, # TODO: Add support for this
							'sub_fields' => []
						];

						# Allow hidden modules
						if ($isHidable) {
							$flexFieldTemplates = array_merge(
								['SLEEK_ACF_HIDDEN_TEMPLATE' => '-- ' . __('Hidden', 'sleek') . ' --'],
								self::getFieldTemplates($fieldName)
							);
						}
						else {
							$flexFieldTemplates = self::getFieldTemplates($fieldName);
						}

						# Automatically add the layout/template field
						$flexFieldLayout['sub_fields'][] = [
							'key' => $flexFieldLayoutKey . '_template',
							'name' => 'template',
							'label' => __('Layout', 'sleek'),
							'instructions' => $isHidable ? __('Choose a layout or temporarily hide the module.', 'sleek') : __('Choose a layout.', 'sleek'),
							'type' => 'select',
							'choices' => $flexFieldTemplates,
							'default_value' => $fieldName . '/default'
						];

						# Finally add the rest of the fields
						$flexFieldLayout['sub_fields'] = array_merge($flexFieldLayout['sub_fields'], $fields);
						$flexField['layouts'][] = $flexFieldLayout;
					}
				}

				$newFields[] = $flexField;
			}
		}

		return $newFields;
	}

	##################################################################
	# Returns a list of templates available for a specific field group
	private static function getFieldTemplates ($fieldName) {
		$templates = array_merge(
			self::getFieldTemplatesInPath(get_template_directory() . '/acf/' . $fieldName . '/', $fieldName),
			self::getFieldTemplatesInPath(get_stylesheet_directory() . '/acf/' . $fieldName . '/', $fieldName)
		);

		asort($templates);

		return $templates;
	}

	###############################################
	# Return a list of templates in a specific path
	private static function getFieldTemplatesInPath ($path, $fieldName) {
		$templates = [];

		if (file_exists($path)) {
			$files = scandir($path);
			$files = array_diff($files, ['.', '..', 'config.php', '.DS_Store', 'Thumbs.db']);

			foreach ($files as $file) {
				$pathInfo = pathinfo($file);

				if (isset($pathInfo['filename']) and substr($pathInfo['filename'], 0, 2) !== '__' and isset($pathInfo['extension']) and $pathInfo['extension'] === 'php') {
					$templateNiceName = __(ucfirst(str_replace(['-', '_'], ' ', $pathInfo['filename'])), 'sleek');
					$templates[$fieldName . '/' . $pathInfo['filename']] = $templateNiceName;
				}
			}
		}

		return $templates;
	}

	#############################
	# Includes a field definition
	# located in acf/field-name/config.php and gives it unique keys
	private static function loadFieldDefinition ($fieldName, $keyPrefix) {
		$fieldGroup = false;

		if ($path = locate_template('acf/' . basename($fieldName) . '/config.php')) {
			$fieldGroup = include $path;
			$fieldGroup = apply_filters('sleek_acf_load_field_definition', $fieldGroup, $fieldName, $keyPrefix);
			$fieldGroup = self::generateFieldKeys($fieldGroup, $keyPrefix);
		}

		return $fieldGroup;
	}

	# Recursively inserts unique keys for every field that has a name
	# https://stackoverflow.com/questions/42121349/recursively-insert-element-next-to-other-element-in-array
	private static function generateFieldKeys ($group, $prefix) {
		foreach ($group as $k => $v) {
			if (is_array($v)) {
				$newPrefix = isset($group['name']) ? $prefix . '_' . $group['name'] : $prefix;
				$group[$k] = self::generateFieldKeys($v, $newPrefix);
			}
			elseif ($k === 'name' and !isset($group['key'])) {
				$group['key'] = $prefix . '_' . $group[$k];
			}
		}

		return $group;
	}

	##################################
	# Add help section for field group
	private static function addHelp ($params) {
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
								$helpSection = self::getHelpSection($field);

								if ($helpSection) {
									$sections[] = $helpSection;
								}
							}
						}
						else {
							$helpSection = self::getHelpSection($v);

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

	##################################
	# Return the help text for a field
	private static function getHelpSection ($field) {
		if ($path = locate_template('acf/' . basename($field) . '/config.php')) {
			$content = file_get_contents($path);

			preg_match('/\/\*\*\*(.*?)\*\*\*\//s', $content, $matches);

			if (count($matches) > 1) {
				$helpText = '<strong>' . self::niceName($field) . '</strong> — ';
				$helpText .= trim($matches[1]);

				return wpautop(__($helpText, 'sleek'));
			}

			return false;
		}

		return false;
	}
}

SleekACF::init();

/**
 * Renders ACF modules with AJAX
 */
add_action('wp_ajax_sleek_acf_render_modules', 'sleek_acf_render_modules_ajax');
add_action('wp_ajax_nopriv_sleek_acf_render_modules', 'sleek_acf_render_modules_ajax');

function sleek_acf_render_modules_ajax () {
	if (isset($_GET['where']) and isset($_GET['post_id'])) {
		ob_start();

		SleekACF::renderModules($_GET['where'], $_GET['post_id']);

		$html = ob_get_clean();

		if ($html) {
			die($html);
		}
	}

	die;
}

add_action('wp_ajax_sleek_acf_render_module', 'sleek_acf_render_module_ajax');
add_action('wp_ajax_nopriv_sleek_acf_render_module', 'sleek_acf_render_module_ajax');

function sleek_acf_render_module_ajax () {
	$module = $_GET['module'] ?? $_POST['module'] ?? null;
	$template = $_GET['template'] ?? $_POST['template'] ?? 'default';
	$postId = $_GET['post_id'] ?? $_POST['post_id'] ?? null;
	$args = $_GET['args'] ?? $_POST['args'] ?? [];

	if ($module and $template and ($path = locate_template('acf/' . $module . '/' . $template . '.php'))) {
		# Render sticky module
		if ($postId) {
			$html = SleekACF::renderStickyModule($module, $postId, $template, false);
		}
		# User has passed in all data
		else {
			$html = sleek_fetch_template_part('acf/' . $module . '/' . $template, $args);
		}

		die($html);
	}
	else {
		die;
	}
}

# Add shortcode to render modules [render_module module="hubspot-cta" hubspot_cta_id="abc-123"]
add_shortcode('render_module', function ($args) {
	$template = isset($args['template']) ? $args['template'] : 'default';

	# ACF module
	if (isset($args['module']) and ($path = locate_template('acf/' . $args['module'] . '/' . $template . '.php'))) {
		# Render sticky module
		if (isset($args['post_id'])) {
			return SleekACF::renderStickyModule($args['module'], $args['post_id'], $template, false);
		}
		# User has passed in all data
		else {
			return sleek_fetch_template_part('acf/' . $args['module'] . '/' . $template, $args);
		}
	}
	# Standard module
	elseif (isset($args['module']) and ($path = locate_template('modules/' . $args['module'] . '.php'))) {
		return sleek_fetch_template_part('modules/' . $args['module']);
	}

	return '[ERROR: Unable to locate module]';
});
