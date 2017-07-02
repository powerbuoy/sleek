<?php
/**
 * Similar to the_archive_title and description but returns an image
 */
function sleek_get_archive_image ($size = 'large') {
	global $_wp_additional_image_sizes;
	global $wp_query;
	global $post;

	$image = false;
	$lang = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : '';

	# Blog pages (category, date, tag etc)
	if ((is_home() or is_category() or is_tag() or is_year() or is_month() or is_day()) and get_option('page_for_posts')) {
		if (has_post_thumbnail(get_option('page_for_posts'))) {
			$image = get_the_post_thumbnail_url(get_option('page_for_posts'), $size);
		}
	}

	# CPT archive
	elseif (is_post_type_archive()) {
		$postType = get_post_type_object($wp_query->query['post_type']);

		if ($imageId = get_option($postType->name . $lang . '_image')) {
			$image = wp_get_attachment_image_src($imageId, $size)[0];
		}
	}

	# Custom taxonomy
	elseif (is_tax()) {
		$postType = get_post_type_object(get_post_type());

		if ($imageId = get_option($postType->name . $lang . '_image')) {
			$image = wp_get_attachment_image_src($imageId, $size)[0];
		}
	}

	# Author
	elseif (is_author()) {
		$user = get_queried_object();

		if (isset($_wp_additional_image_sizes[$size])) {
			$size = $_wp_additional_image_sizes[$size]['width'];
		}
		else {
			$size = 640;
		}

		$image = get_avatar_url($user->ID, ['size' => $size]);
	}

	return $image;
}
