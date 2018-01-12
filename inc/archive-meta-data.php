<?php
# Modify the_archive_title()
add_filter('get_the_archive_title', function ($title) {
	global $wp_query;
	global $post;

	# Blog page should show blog page's the_title()
	if (is_home() and get_option('page_for_posts')) {
		$title = get_the_title(get_option('page_for_posts'));
	}

	# CPT archive should show custom title if set
	elseif (is_post_type_archive() and function_exists('get_field') and $customTitle = get_field('archive-title', $wp_query->query['post_type'] . '-archive-data')) {
		$title = $customTitle;
	}

	# Search should show something nice too
	elseif (is_search()) {
		# With results
		if (have_posts()) {
			# Non-empty search
			if (strlen(trim(get_search_query())) > 0) {
				$title = sprintf(__('Search results (%s) for: <strong>"%s"</strong>', 'sleek'), $wp_query->found_posts, get_search_query());
			}
			# An empty search
			else {
				$title = sprintf(__('Empty search', 'sleek'), $wp_query->found_posts, get_search_query());
			}
		}
		# No search results
		else {
			$title = sprintf(__('No search results for: <strong>"%s"</strong>', 'sleek'), get_search_query());
		}
	}

	# Default (remove PREFIX:)
	else {
		$title = preg_replace('/^(.*?): /', '', $title);
	}

	return $title;
});

# Modify the_archive_description()
add_filter('get_the_archive_description', function ($description) {
	global $wp_query;
	global $post;

	# Blog page should show blog page's the_title()
	if (is_home() and get_option('page_for_posts')) {
		$description = apply_filters('the_content', get_post_field('post_content', get_option('page_for_posts')));
	}

	# CPT archive should show custom title if set
	elseif (is_post_type_archive() and function_exists('get_field') and $customDescription = get_field('archive-description', $wp_query->query['post_type'] . '-archive-data')) {
		$description = $customDescription;
	}

	# Search should show something nice too
	elseif (is_search()) {
		# With results
		if (have_posts()) {
			# Non-empty search
			if (strlen(trim(get_search_query())) > 0) {
				$total = $wp_query->found_posts;
				$currPage = $wp_query->query_vars['paged'] ? $wp_query->query_vars['paged'] : 1;
				$numPerPage = $wp_query->query_vars['posts_per_page'];
				$resFrom = ($currPage * $numPerPage - $numPerPage) + 1;
				$resTo = ($resFrom + $numPerPage) - 1;
				$resTo = $resTo > $total ? $total : $resTo;

				$description = '<p>' . sprintf(__('Displaying results %d through %d', 'sleek'), $resFrom, $resTo) . '</p>';
			}
			# An empty search
			else {
				$description = '<p>' . __("You didn't search for anything in particular so I'm showing you everything", 'sleek') . '</p>';
			}
		}
		# No search results
		else {
			$description = '<p>' . __("We couldn't find any matching search results for your query.", 'sleek') . '</p>';
		}
	}

	# Author: WP doesn't wrap this in a <p>
	elseif (is_author()) {
		$description = wpautop(get_the_author_meta('description'));
	}

	return $description;
});

/**
 * Similar to the_archive_title and description but returns an image
 * TODO: Check for ACF images added to categories
 */
function sleek_get_the_archive_image ($size = 'large') {
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
	elseif (is_post_type_archive() and function_exists('get_field') and $imageId = get_field('archive-image', $wp_query->query['post_type'] . '-archive-data')) {
		$image = wp_get_attachment_image_src($imageId, $size)[0];
	}

	# Custom taxonomy
	elseif (is_tax() and function_exists('get_field') and $imageId = get_field('archive-image', get_post_type() . '-archive-data')) {
		$image = wp_get_attachment_image_src($imageId, $size)[0];
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

/**
 * Adds ACF options pages to all archives specified containing title, description and image fields
 */
function sleek_archive_meta_data ($postTypes) {
	if (!(function_exists('acf_add_options_page') and function_exists('acf_add_local_field_group'))) {
		return false;
	}

	foreach ($postTypes as $key => $value) {
		$postType = $value;

		if (is_array($value)) {
			$postType = $key;
		}

		# Create the options page
		acf_add_options_page([
			'page_title' => __('Archive Title & Description', 'sleek'),
			'menu_slug' => $postType . '-archive-data',
			'parent_slug' => 'edit.php?post_type=' . $postType,
			'icon_url' => 'dashicons-welcome-write-blog',
			'post_id' => $postType . '-archive-data'
		]);

		# Add some standard fields (title, description, image)
		$groupKey = 'group_' . $postType . '-archive-data';

		acf_add_local_field_group([
			'key' => $groupKey,
			'title' => __('Archive Title & Description', 'sleek'),
			'fields' => [
				[
					'label' => __('Title', 'sleek'),
					'key' => 'field_' . $groupKey . '_title',
					'name' => 'archive-title',
					'type' => 'text'
				],
				[
					'label' => __('Image', 'sleek'),
					'key' => 'field_' . $groupKey . '_image',
					'name' => 'archive-image',
					'type' => 'image',
					'return_format' => 'id'
				],
				[
					'label' => __('Description', 'sleek'),
					'key' => 'field_' . $groupKey . '_description',
					'name' => 'archive-description',
					'type' => 'wysiwyg',
					'media_upload' => false
				]
			],
			'location' => [[[
				'param' => 'options_page',
				'operator' => '==',
				'value' => $postType . '-archive-data'
			]]]
		]);
	}
}

function sleek_get_archive_meta ($field, $pt = false) {
	if (!function_exists('get_field')) {
		return false;
	}

	if (!$pt) {
		$pt = sleek_get_current_post_type();
	}

	if ($pt == 'post') {
		return get_field($field, get_option('page_for_posts'));
	}
	else {
		return get_field($field, $pt  . '-archive-data');
	}

	return $value;
}
