<?php
# Add custom logo support
add_theme_support('custom-logo', [
	'header-text' => [get_bloginfo('name'), get_bloginfo('description')]
]);

function sleek_get_site_logo () {
	# Check custom logo
	if ($customLogoId = get_theme_mod('custom_logo')) {
		$logo = '<img src="' . wp_get_attachment_image_src($customLogoId, 'full')[0] . '" alt="' . get_bloginfo('name') . '">';
	}
	# Check site-logo.svg
	elseif ($svgLogo = locate_template('dist/assets/svg/site-logo.svg')) {
		$logo = str_replace('<svg', '<svg aria-label="' . get_bloginfo('name') . '"', file_get_contents($svgLogo)); # TODO: Is aria-label still correct? # TODO: Do I need to remove <?xml etc?
	}
	# Check site-logo.png
	elseif (file_exists(get_stylesheet_directory() . '/dist/assets/site-logo.png')) {
		$logo = '<img src="' . get_stylesheet_directory_uri() . '/dist/assets/site-logo.png' . '" alt="' . get_bloginfo('name') . '">';
	}
	# Default to text (with <tag> support)
	else {
		$logo = str_replace(['&lt;', '&gt;'], ['<', '>'], get_bloginfo('name'));
	}

	return $logo;
}
