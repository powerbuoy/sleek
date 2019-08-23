<?php
# Add custom logo support
add_theme_support('custom-logo', [
	'header-text' => [get_bloginfo('name'), get_bloginfo('description')]
]);

add_filter('get_custom_logo', function ($html) {
	$append = (is_array($html) and isset($html['append'])) ? $html['append'] : '';
	$inlineSvg = (is_array($html) and isset($html['inline_svg'])) ? true : false;

	# User has not defined a custom logo - include our own
	if (empty($html) or is_array($html)) {
		$alt = get_bloginfo('name');

		if (get_bloginfo('description')) {
			$alt .= ' - ' . get_bloginfo('description');
		}

		# Check site-logo.svg
		if ($svgLogo = locate_template('dist/assets/svg/site-logo' . $append . '.svg')) {
			if ($inlineSvg) {
				# TODO: Is aria-label still correct? # TODO: Should I remove <?xml etc?
				$logo = str_replace('<svg', '<svg aria-label="' . $alt . '"', file_get_contents($svgLogo));
			}
			else {
				$logo = '<img src="' . get_stylesheet_directory_uri() . '/dist/assets/svg/site-logo' . $append . '.svg' . '" alt="' . $alt . '">';
			}
		}
		# Check site-logo.png
		elseif (file_exists(get_stylesheet_directory() . '/dist/assets/site-logo.png')) {
			$logo = '<img src="' . get_stylesheet_directory_uri() . '/dist/assets/site-logo' . $append . '.png' . '" alt="' . $alt . '">';
		}
		# Default to text (with <tag> support)
		else {
			$logo = str_replace(['&lt;', '&gt;'], ['<', '>'], get_bloginfo('name'));
		}

		return '<a href="' . home_url('/') . '" class="site-logo">' . $logo . '</a>';
	}
	else {
		$html = str_replace('custom-logo-link', 'site-logo', $html);
	}

	return $html;
}, 10, 1);
