<?php
# Remove gallery inline styles (WP shines again!) (https://css-tricks.com/snippets/wordpress/remove-gallery-inline-styling/)
add_filter('use_default_gallery_style', '__return_false');

# Wrap images in figure elements
# https://wordpress.stackexchange.com/questions/174582/always-use-figure-for-post-images
add_filter('the_content', function ($content) {
	return preg_replace('/<p>\\s*?(<a.*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $content);
}, 99);

# Replace the [caption] HTML
add_filter('img_caption_shortcode', function ($empty, $atts, $content) {
	$atts = shortcode_atts([
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	], $atts);

	$html = '<figure class="' . esc_attr($atts['align']) . '">';
	$html .= do_shortcode($content);
	$html .= '<figcaption>' . esc_attr($atts['caption']) . '</ficaption>';
	$html .= '</figure>';

	return $html;
}, 10, 3);

# Completely rewrite WP's ludicrous gallery output
# https://stackoverflow.com/questions/14585538/customise-the-wordpress-gallery-html-layout
add_filter('post_gallery', function ($string, $attr) {
	$images = get_posts([
		'post_type' => 'attachment',
		'include' => $attr['ids']
	]);

	# FFS... When 3 cols are used WP doesn't set this attribute
	if (!isset($attr['columns'])) {
		$attr['columns'] = 3;
	}

	$html = '<div class="gallery gallery-columns-' . $attr['columns'] . '">';

	foreach ($images as $image) {
		$html .= '<figure>';

		# If no link is set that means we should link to media page
		if (!isset($attr['link'])) {
			$html .= '<a href="' . get_permalink($image->ID) . '">';
		}
		# Link to file
		elseif ($attr['link'] == 'file') {
			$html .= '<a href="' . wp_get_attachment_image_src($image->ID, 'full')[0] . '">';
		}

		# Add the actual image
		$html .= wp_get_attachment_image($image->ID, $attr['size']);

		# Close link
		if (!isset($attr['link']) or $attr['link'] != 'none') {
			$html .= '</a>';
		}

		# Add potential caption
		if ($image->post_excerpt) {
			$html .= '<figcaption>' . get_the_excerpt($image) . '</figcaption>';
		}

		$html .= '</figure>';
	}

	$html .= '</div>';

	return $html;
}, 10, 2);
