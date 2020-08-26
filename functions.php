<?php
########
# Vendor
require __DIR__ . '/vendor/autoload.php';

###################
# Load translations
load_theme_textdomain('sleek', get_template_directory() . '/dist');

################
# Sleek settings
# Core
add_theme_support('sleek/classic_editor');
add_theme_support('sleek/jquery_cdn');
add_theme_support('sleek/disable_jquery');
add_theme_support('sleek/disable_404_guessing');
add_theme_support('sleek/nice_email_from');
add_theme_support('sleek/disable_theme_editor');
# add_theme_support('sleek/get_terms_post_type_arg');

# ACF
add_theme_support('sleek/acf/hide_admin');
# add_theme_support('sleek/acf/fields/redirect_url');

# ArchiveFilter
# add_theme_support('sleek/archive_filter');

# Cleanup
add_theme_support('sleek/cleanup/comment_form_placeholders');
# add_theme_support('sleek/cleanup/disable_comments');

# Gallery
# add_theme_support('sleek/gallery/slideshow');
add_theme_support('sleek/oembed/responsive_video');
# add_theme_support('sleek/oembed/data_src');

# Login
add_theme_support('sleek/login/styling');
# add_theme_support('sleek/login/require_login');

# Modules
add_theme_support('sleek/modules/module_preview');
add_theme_support('sleek/modules/inline_edit');
add_theme_support('sleek/modules/add_new_module_preview');
# add_theme_support('sleek/modules/global_modules');

# Notices
add_theme_support('sleek/notices/outdated_browser_warning');
# add_theme_support('sleek/notices/cookie_consent');

# PostTypes
# add_theme_support('sleek/post_types/settings_pages'); # TODO: ??

# TinyMCE
add_theme_support('sleek/tinymce/disable_colors');
add_theme_support('sleek/tinymce/clean_paste');

########
# Assets
/* add_action('wp_enqueue_scripts', function () {
	wp_enqueue_script('vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.11', [], null, true);
}); */

#############
# Image sizes
Sleek\ImageSizes\register(1920, 1080, ['center', 'center']/*, [
	'portrait' => ['width' => 1080, 'height' => 1920, 'crop' => ['center', 'top']],
	'square' => ['width' => 1920, 'height' => 1920],
]*/);

##################
# Sidebars & menus
# register_sidebar(['name' => __('Header', 'sleek'), 'id' => 'header']);
# register_sidebar(['name' => __('Footer', 'sleek'), 'id' => 'footer']);
# register_sidebar(['name' => __('Sidebar', 'sleek'), 'id' => 'sidebar']);

register_nav_menus([
	'header_menu' => __('Header menu', 'sleek'),
	'footer_menu' => __('Footer menu', 'sleek')
]);

################
# Sleek settings
/* add_action('admin_init', function () {
	Sleek\Settings\add_setting('hubspot_portal_id', 'text', __('Hubspot Portal ID', 'sleek'));
	Sleek\Settings\add_setting('hubspot_api_key', 'text', __('Hubspot API Key', 'sleek'));
});

# ... use them
add_action('wp_head', function () {
	if ($portalId = Sleek\Settings\get_setting('hubspot_portal_id')) {
		echo '<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/' . $portalId . '.js"></script>';
	}
}); */

############
# ACF fields
add_action('acf/init', function () {
	# Site Settings Page
/*	acf_add_options_page([
		'page_title' => __('Site Settings', 'sleek'),
		'menu_slug' => 'site_settings',
		'post_id' => 'site_settings'
	]); */

	# Site Setting Fields
/*	acf_add_local_field_group([
		'key' => 'site_settings',
		'title' => __('Site Settings', 'sleek'),
		'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'site_settings']]],
		'menu_order' => 0,
		'fields' => [
			[
				'key' => 'site_settings_message',
				'name' => 'message',
				'type' => 'message',
				'label' => __('Nothing here', 'sleek'),
				'message' => __('Nothing here yet.', 'sleek')
			]
		]
	]); */

	# Sidebar Modules
/*	acf_add_local_field_group([
		'key' => 'group_sidebar_modules',
		'title' => __('Sidebar Modules', 'sleek'),
		'location' => [[['param' => 'options_page', 'operator' => '==', 'value' => 'site_settings']]],
		'menu_order' => 1,
		'fields' => [
			[
				'key' => 'sidebar_modules',
				'name' => 'sidebar_modules',
				'type' => 'flexible_content',
				'label' => __('Sidebar Modules', 'sleek'),
				'button_label' => __('Add a module', 'sleek'),
				'layouts' => Sleek\Acf\generate_keys(
					Sleek\Modules\get_module_fields([
						'text-block' # Add more modules as needed
					], 'flexible'),
					'sidebar_modules'
				)
			]
		]
	]); */

	# Make site settings translatable
	/*	add_filter('acf/validate_post_id', function ($postId) {
		if ($postId == 'site_settings') {
			$dl = acf_get_setting('default_language');
			$cl = acf_get_setting('current_language');

			if ($cl and $cl !== $dl) {
				$postId .= '_' . $cl;
			}
		}

		return $postId;
	}); */
});

##################################
# Add common fields to all modules
/* add_filter('sleek/modules/fields', function ($fields, $module) {
	# Add background image to these modules
	if (in_array($module, ['text-block', 'text-blocks'])) {
		array_unshift($fields, [
			'name' => 'background_color',
			'label' => __('Background Color', 'sleek'),
			'type' => 'select',
			'choices' => [
				'transparent' => __('Transparent', 'sleek'),
				'light' => __('Light', 'sleek'),
				'dark' => __('Dark', 'sleek')
			],
			'default_value' => 'transparent'
		]);
	}

	return $fields;
}, 10, 2); */
