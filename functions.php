<?php
##########
# Composer
require __DIR__ . '/vendor/autoload.php';

########
# Assets
# add_action('wp_enqueue_scripts', function () {wp_enqueue_script('https://vue.js')}); # TODO: Is this action really needed? What happens without it? Will it run on all pages? Including login_enqueue_scripts and the admin?

###############
# Theme support
# TODO: Make sure all of these actually work even though they're included by autoload.php (I mean, that code has already run when we say change the theme_support... hmm) Especially if we runt it inside after_setup_theme eh? Test this!
add_action('after_setup_theme', function () {
	# Disabled by default
	# add_theme_support('sleek-archive-filter');
	# add_theme_support('sleek-get-terms-post-type-arg')
	# add_theme_support('sleek-require-login');

	# Enabled by default
	# remove_theme_support('sleek-mobile-viewport');
	# remove_theme_support('sleek-classic-editor');
	# remove_theme_support('sleek-jquery-cdn');
	# remove_theme_support('sleek-disable-404-guessing');
	# remove_theme_support('sleek-nice-email-from');
	# remove_theme_support('sleek-comment-form-placeholders');
	# remove_theme_support('sleek-tinymce-clean-paste');
	# remove_theme_support('sleek-tinymce-no-colors');
});

##################
# ACF module areas
add_action('acf/init', function () {
	Sleek\Acf\add_module_area([
		'name' => 'below_content',
		'modules' => ['text-block'],
		'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'page']]]
	]);
});

#################
# More ACF fields
add_action('acf/init', function () {
	acf_add_options_page([
		'page_title' => __('Site Settings', 'sleek'),
		'menu_slug' => 'site-settings',
		'post_id' => 'site_settings' # NOTE: Use this id in get_field('my_field', 'theme_settings')
	]);

	# TODO... many more examples of fields in nav-menus, taxonomies, options-pages, etc etc
});

#############
# Image sizes
# TODO: Do we need an action?
Sleek\ImageSizes\register(1920, 1080, ['center', 'center']/*, [
	'portrait' => ['width' => 1080, 'height' => 1920, 'crop' => ['center', 'top']],
	'square' => ['width' => 1920, 'height' => 1920],
]*/);

##########
# Sidebars
# TODO: Do we need add_action init?
register_sidebar(['name' => __('Header', 'sleek'), 'id' => 'header']);
register_sidebar(['name' => __('Footer', 'sleek'), 'id' => 'footer']);
register_sidebar(['name' => __('Aside', 'sleek'), 'id' => 'aside']);

################
# Menu locations
# TODO: Do we need add_action init?
register_nav_menus([
	'main-menu' => __('Main menu', 'sleek')
]);

################
# Sleek settings
# TODO: Why this action?
add_action('admin_init', function () {
	Sleek\Settings\add_setting([
		'name' => 'hubspot_portal_id',
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
