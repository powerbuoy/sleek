<?php function sleek_module_class ($styles) {
	$classes = [];
	$cos = 'container'; # Default to container

	# We have a background image
	if (!empty($styles['color_scheme']['media']['media'])) {
		$cos = 'section';

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
		$cos = 'section';
		$classes[] = 'bg--' . $styles['color_scheme']['bg_color'];
	}

	# Text align
	if (!empty($styles['text_align']) and $styles['text_align'] !== 'inherit') {
		$classes[] = 'text--' . $styles['text_align'];
	}

	# Media position
	if (!empty($styles['media_position'])) {
		$classes[] = 'media-position--' . $styles['media_position'];
	}

	# Media alignment??

	# Module size
	if (!empty($styles['module_size']) and $styles['module_size'] !== 'full') {
		$cos .= '--' . $styles['module_size'];
	}

	return $cos . ' ' . implode(' ', $classes);
}