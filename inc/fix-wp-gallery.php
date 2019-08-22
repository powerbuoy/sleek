<?php
# Remove gallery inline styles (WP shines again!) (https://css-tricks.com/snippets/wordpress/remove-gallery-inline-styling/)
add_filter('use_default_gallery_style', '__return_false');

# Wrap videos in div.video
# https://wordpress.stackexchange.com/questions/50779/how-to-wrap-oembed-embedded-video-in-div-tags-inside-the-content
add_filter('embed_oembed_html', function($html, $url, $attr, $post_id) {
	return '<div class="video">' . $html . '</div>';
}, 99, 4);

# Wrap images in figure elements
# https://wordpress.stackexchange.com/questions/174582/always-use-figure-for-post-images
# NOTE: <p>text<img>text</p> will result in <figure><img></figure> + this interferes with other the_content filters so removed for now
/* add_filter('the_content', function ($content) {
	if (strlen($content) == 0) {
		return $content;
	}

	libxml_use_internal_errors(true); # https://stackoverflow.com/questions/9149180/domdocumentloadhtml-error

	# Load the content
	$dom = new DOMDocument();

	# https://stackoverflow.com/questions/8218230/php-domdocument-loadhtml-not-encoding-utf-8-correctly
	$dom->loadHTML('<?xml encoding="utf-8" ?>' . $content);

	# Find all images
	$images = $dom->getElementsByTagName('img');

	foreach ($images as $image) {
		$child = $image;
		$wrapper = $image->parentNode;

		# If the image is linked
		if ($wrapper->tagName == 'a') {
			$child = $wrapper; # Store the link
			$wrapper = $wrapper->parentNode; # And its parent
		}

		# If the parent is a <p> - replace it with a <figure>
		if ($wrapper->tagName == 'p') {
			$figure = $dom->createElement('figure');

			$figure->setAttribute('class', $image->getAttribute('class')); # Give figure same class as img
			$image->setAttribute('class', ''); # Remove img class
			$figure->appendChild($child); # Add img to figure
			$wrapper->parentNode->replaceChild($figure, $wrapper); # Replace <p> with <figure>
		}
	}

	libxml_use_internal_errors(false); # Turn on errors again...

	# Strip DOCTYPE etc
	return str_replace(['<body>', '</body>'], '', $dom->saveHTML($dom->getElementsByTagName('body')->item(0)));
}, 99); */

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

	# If no size is set - set it to full
	if (!isset($attr['size'])) {
		$attr['size'] = 'full';
	}

	$html = '<div class="gallery gallery--cols-' . $attr['columns'] . '">';

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
