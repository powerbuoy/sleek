<?php
# Modify the_archive_title()
add_filter('get_the_archive_title', function ($title) {
	global $wp_query;
	global $post;

	# Blog page should show blog page's the_title()
	if (is_home() and get_option('page_for_posts')) {
		$title = get_the_title(get_option('page_for_posts'));
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

	# CPT archive should show custom title if set
	elseif (is_post_type_archive() and function_exists('get_field') and $customTitle = get_field('archive_title', $wp_query->query['post_type'] . '_archive_meta')) {
		$title = $customTitle;
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

	# Blog page should show blog page's the_content()
	if (is_home() and get_option('page_for_posts')) {
		$description = apply_filters('the_content', get_post_field('post_content', get_option('page_for_posts')));
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

	# CPT archive should show custom description if set
	elseif (is_post_type_archive() and function_exists('get_field') and $customDescription = get_field('archive_description', $wp_query->query['post_type'] . '_archive_meta')) {
		$description = $customDescription;
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

	# Blog pages (category, date, tag etc)
	if ((is_home() or is_category() or is_tag() or is_year() or is_month() or is_day()) and get_option('page_for_posts')) {
		if (has_post_thumbnail(get_option('page_for_posts'))) {
			$image = get_the_post_thumbnail_url(get_option('page_for_posts'), $size);
		}
	}

	# CPT archive
	elseif (is_post_type_archive() and function_exists('get_field') and $imageId = get_field('archive_image', $wp_query->query['post_type'] . '_archive_meta')) {
		$image = wp_get_attachment_image_src($imageId, $size)[0];
	}

	# Custom taxonomy
	elseif (is_tax() and function_exists('get_field') and $imageId = get_field('archive_image', get_post_type() . '_archive_meta')) {
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
		sleek_acf_add_options_page([
			'page_title' => __('Archive Settings', 'sleek'),
			'menu_slug' => $postType . '_archive_meta',
			'parent_slug' => 'edit.php?post_type=' . $postType,
			'icon_url' => 'dashicons-welcome-write-blog',
			'post_id' => $postType . '_archive_meta'
		]);

		# Add some standard fields (title, description, image)
		$groupKey = 'group_' . $postType . '_archive_meta';

		acf_add_local_field_group([
			'key' => $groupKey,
			'title' => __('Archive Settings', 'sleek'),
			'fields' => [
				[
					'label' => __('Title', 'sleek'),
					'key' => 'field_' . $groupKey . '_title',
					'name' => 'archive_title',
					'type' => 'text'
				],
				[
					'label' => __('Image', 'sleek'),
					'key' => 'field_' . $groupKey . '_image',
					'name' => 'archive_image',
					'type' => 'image',
					'return_format' => 'id'
				],
				[
					'label' => __('Description', 'sleek'),
					'key' => 'field_' . $groupKey . '_description',
					'name' => 'archive_description',
					'type' => 'wysiwyg'
				]
			],
			'location' => [[[
				'param' => 'options_page',
				'operator' => '==',
				'value' => $postType . '_archive_meta'
			]]]
		]);
	}

	sleek_archive_meta_menus($postTypes);
}

function sleek_archive_meta_menus ($pts) {
	add_action('admin_bar_menu', function ($wp_admin_bar) use ($pts) {
		global $wp_query;

		# Store all our Post types
		$postTypes = [];

		# Get all Post type name
		foreach ($pts as $key => $value) {
			if (is_array($value)) {
				$postTypes[] = $key;
			}
			else {
				$postTypes[] = $value;
			}
		}

		# Add Admin bar button to Archive Settings
		if (is_admin()) {
			$page = get_current_screen();

			if (
				in_array($page->post_type, $postTypes) and # Only Archive types with Sleek Archive settings
				$page->id == $page->post_type . '_page_' . $page->post_type . '_archive_meta' # Only Archive Settings page
			) {
				$wp_admin_bar->add_menu([
					'id' => 'view', # NOTE: Same ID as WP uses for its view links (for styling purposes)
					'title' => sprintf(__('View %s archive', 'sleek'), get_post_type_object($page->post_type)->labels->singular_name),
					'href' => get_post_type_archive_link($page->post_type),
				]);
			}
		}

		# Add Admin bar button to Archive Front
		if (
			!is_admin() and # Not much use for the link in the admin.
			is_post_type_archive() and # Only on post archive pages.
			$wp_query->queried_object->show_ui and # The post type should be showing its UI.
			current_user_can($wp_query->queried_object->cap->edit_posts) and # And the current user should be able to edit this post type.
			in_array($wp_query->queried_object->name, $postTypes) # Only Archive types with Sleek Archive Settings
		) {
			$wp_admin_bar->add_menu([
				'id' => 'edit', # NOTE: Same ID as WP uses for its edit links (for styling purposes)
				'title' => sprintf(__('Edit %s archive', 'sleek'), $wp_query->queried_object->labels->singular_name),
				'href' => admin_url('edit.php?post_type=' . $wp_query->queried_object->name . '&page=' . $wp_query->queried_object->name . '_archive_meta'),
			]);
		}
	}, 80);
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
		return get_field($field, $pt  . '_archive_meta');
	}

	return $value;
}
