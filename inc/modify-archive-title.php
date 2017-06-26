<?php
# Modify the_archive_title()
add_filter('get_the_archive_title', function ($title) {
	global $wp_query;
	global $post;

	$lang = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : '';

	# Blog page should show blog page's the_title()
	if (is_home() and get_option('page_for_posts')) {
		$title = get_the_title(get_option('page_for_posts'));
	}

	# CPT archive should show custom title if set
	elseif (is_post_type_archive() and $customTitle = get_option($wp_query->query['post_type'] . $lang . '_title')) {
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
		$title = preg_replace('/^\w+: /', '', $title);
	}

	return $title;
});

# Modify the_archive_description
add_filter('get_the_archive_description', function ($description) {
	global $wp_query;
	global $post;

	$lang = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : '';

	# Blog page should show blog page's the_title()
	if (is_home() and get_option('page_for_posts')) {
		$description = apply_filters('the_content', get_post_field('post_content', get_option('page_for_posts')));
	}

	# CPT archive should show custom title if set
	elseif (is_post_type_archive() and $customDescription = get_option($wp_query->query['post_type'] . $lang . '_description')) {
		$description = wpautop($customDescription); # NOTE: Is wpautop needed? This data is entered in a WYSIWYG-editor...
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

	return $description;
});
