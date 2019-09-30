<?php
########################
# Set up for translation
# NOTE: Load this first thing so translations are available everywhere
load_theme_textdomain('sleek', get_template_directory() . '/languages');

###############
# Theme support
# NOTE: These need to be set before composer autoload
add_theme_support('sleek-classic-editor');
add_theme_support('sleek-jquery-cdn');
add_theme_support('sleek-disable-404-guessing');
add_theme_support('sleek-nice-email-from');
add_theme_support('sleek-comment-form-placeholders');
add_theme_support('sleek-tinymce-clean-paste');
add_theme_support('sleek-tinymce-no-colors');
add_theme_support('sleek-archive-meta');

# Disabled by default
# add_theme_support('sleek-gallery-slideshow');
# add_theme_support('sleek-archive-filter');
# add_theme_support('sleek-get-terms-post-type-arg');
# add_theme_support('sleek-require-login');

##########
# Composer
require __DIR__ . '/vendor/autoload.php';

########
# Assets
# TODO: Example of adding more assets than main.css/main.js
# add_action('wp_enqueue_scripts', function () {wp_enqueue_script('https://vue.js')});

##################
# ACF module areas
add_action('__acf/init', function () {
	Sleek\Acf\add_module_area([
		'name' => 'below_content',
		'modules' => ['text-block'],
		'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'page']]]
	]);
});

#################
# More ACF fields
add_action('acf/init', function () {
	# Options page
	acf_add_options_page([
		'page_title' => __('Site Settings', 'sleek'),
		'menu_slug' => 'site-settings',
		'post_id' => 'site_settings' # NOTE: Use this id in get_field('my_field', 'site_settings')
	]);

	# TODO... many more examples of fields in nav-menus, taxonomies, options-pages, etc etc
});

#############
# Image sizes
Sleek\ImageSizes\register(1920, 1080, ['center', 'center']/*, [
	'portrait' => ['width' => 1080, 'height' => 1920, 'crop' => ['center', 'top']],
	'square' => ['width' => 1920, 'height' => 1920],
]*/);

##################
# Sidebars & menus
register_sidebar(['name' => __('Header', 'sleek'), 'id' => 'header']);
register_sidebar(['name' => __('Footer', 'sleek'), 'id' => 'footer']);
register_sidebar(['name' => __('Aside', 'sleek'), 'id' => 'aside']);

register_nav_menus(['main-menu' => __('Main menu', 'sleek')]);

################
# Sleek settings
add_action('admin_init', function () {
	Sleek\Settings\add_setting('hubspot_portal_id', [
		'label' => __('Hubspot Portal ID', 'sleek'),
		'type' => 'text'
	]);
});

# ... use them
add_action('wp_head', function () {
	if ($portalId = Sleek\Settings\get_setting('hubspot_portal_id')) {
		echo '<script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/' . $portalId . '.js"></script>';
	}
});

#############
# User fields
/* add_filter('user_contactmethods', function ($fields) {
	$fields['tagline'] = __('Tagline', 'sleek_child');
	$fields['phone'] = __('Telephone', 'sleek_child');
	$fields['facebook'] = __('Facebook', 'sleek_child');
	$fields['twitter'] = __('Twitter', 'sleek_child');
	$fields['instagram'] = __('Instagram', 'sleek_child');
	$fields['linkedin'] = __('LinkedIn', 'sleek_child');
	$fields['googleplus'] = __('Google+', 'sleek_child');
	$fields['stackoverflow'] = __('StackOverflow', 'sleek_child');
	$fields['github'] = __('GitHub', 'sleek_child');

	return $fields;
}); */

#################
# REST API Fields
# NOTE: Add more post types and fields as needed
/* add_action('rest_api_init', function () {
	register_rest_field(['page', 'post'], 'custom_fields', ['get_callback' => function ($post) {
		return get_post_custom($post['id']);
	}]);
}); */
