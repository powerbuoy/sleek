<?php function sleek_module_class ($styles) {
	$classes = [];

	# We have a background image
	if (!empty($styles['color_scheme']['media']['media'])) {
		$classes[] = 'section';

		if ($styles['color_scheme']['media']['light_media']) {
			$classes[] = 'bg--media-light';
		}
		else {
			$classes[] = 'bg--media';
		}

		if ($styles['color_scheme']['media']['media_overlay']) {
			$classes[] = 'bg--overlay';
		}
	}
	# We have a background color
	elseif (!empty($styles['color_scheme']['bg_color']) and $styles['color_scheme']['bg_color'] !== 'transparent') {
		$classes[] = 'section';
		$classes[] = 'bg--' . $styles['color_scheme']['bg_color'];
	}
	# Transparent
	else {
		$classes[] = 'container';
	}

	# TODO:
	# Media position
	# Media alignment
	# Module spacing top
	# Module spacing bottom
	# Module size

	return implode(' ', $classes);
}