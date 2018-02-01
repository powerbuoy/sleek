<?php
/**
 * Attempts to return the currently viewed post type
 */
function sleek_get_current_post_type () {
	# Work out the post type on this archive
	$qo = get_queried_object();

	# Singular
	if (is_singular()) {
		$pt = get_post_type();
	}
	# Post type archive
	elseif ($qo instanceof WP_Post_Type) {
		$pt = $qo->name;
	}
	# Blog archive
	elseif ($qo instanceof WP_Post) {
		$pt = 'post';
	}
	# Try to get post type like this (NOTE: this will fetch the _first_ post's post type)
	else {
		$pt = get_post_type();
	}

	return $pt;
}

/**
 * Returns the current page type
 */
function sleek_get_page_type () {
	global $post;

	$pageType = 'unknown';

	if (is_front_page())		$pageType = 'front';
	elseif (is_single())		$pageType = 'post';
	elseif (is_attachment())	$pageType = 'attachment';
	elseif (is_page())			$pageType = 'page';
	elseif (is_archive())		$pageType = 'archive';
	elseif (is_search())		$pageType = 'search';
	elseif (is_home())			$pageType = 'blog';

	return $pageType;
}

/**
 * Returns estimated reading time for $post
 * http://ryanfrankel.com/how-to-find-the-number-of-words-in-a-post-in-wordpress/
 */
function sleek_get_reading_time ($post) {
	$numWords = str_word_count(strip_tags(get_post_field('post_content', $post->ID)));
	$min = ceil($numWords / 200); # NOTE: 200 words per minute seems normal; http://www.readingsoft.com/

	return $min;
}


/**
 * Returns an array of terms
 */
function sleek_get_post_terms ($id, $pt, $linked = false, $type = 'category', $field = 'name', &$taxonomy = null) {
	$terms = [];
	$tmp = false;

	# Convert tag to correct tax name
	if ($pt == 'post' and $type == 'tag') {
		$tmp = wp_get_post_terms($id, 'post_tag');
		$taxonomy = 'post_tag';
	}
	# And category...
	elseif ($pt == 'post' and $type == 'category') {
		$tmp = wp_get_post_terms($id, 'category');
		$taxonomy = 'category';
	}
	# Custom taxonomies are assumed to be named ${post-type-name}_category
	elseif (taxonomy_exists($pt . '_' . $type)) {
		$tmp = wp_get_post_terms($id, $pt . '_' . $type);
		$taxonomy = $pt . '_' . $type;
	}
	# Also check to see if this pt has the category taxonomy
	elseif ($type == 'category' and is_object_in_taxonomy($pt, 'category')) {
		$tmp = wp_get_post_terms($id, 'category');
		$taxonomy = 'category';
	}
	# Also check to see if this pt has the tag taxonomy
	elseif ($type == 'tag' and is_object_in_taxonomy($pt, 'post_tag')) {
		$tmp = wp_get_post_terms($id, 'post_tag');
		$taxonomy = 'post_tag';
	}

	if ($tmp) {
		foreach ($tmp as $t) {
			if ($linked) {
				$terms[] = '<a href="' . get_term_link($t) . '">' . $t->{$field} . '</a>';
			}
			else {
				$terms[] = $t->{$field};
			}
		}
	}

	return $terms;
}

/**
 * Returns the current author either on /author/username/ or a single blog post
 */
function sleek_get_current_author () {
	$usr = false;

	if (get_query_var('author_name')) {
		$usr = get_user_by('slug', get_query_var('author_name'));
	}
	else {
		$usr = get_user_by('id', get_query_var('author'));
	}

	if (!$usr) {
		$usr = get_user_by('id', get_the_author_meta('ID'));
	}

	return $usr;
}

/**
 * Search a multidimensional array for key/value
 * http://stackoverflow.com/questions/1019076/how-to-search-by-key-value-in-a-multidimensional-array-in-php
 */
function sleek_array_search_r ($array, $key, $value = false) {
	$results = [];

	if (is_array($array)) {
		if (isset($array[$key]) && ($value === false or ($value !== false && $array[$key] == $value))) {
			$results[] = $array;
		}

		foreach ($array as $subarray) {
			$results = array_merge($results, sleek_array_search_r($subarray, $key, $value));
		}
	}

	return $results;
}

/**
 * Like get_template_part but accepts arguments
 * NOTE: Never pass in any of the reserved query vars!
 * https://codex.wordpress.org/WordPress_Query_Vars
 */
function sleek_get_template_part ($path, $args = []) {
	foreach ($args as $k => $v) {
		set_query_var($k, $v);
	}

	get_template_part($path);
}

/**
 * Returns neighbouring array element with optional offset
 * TODO: URL? Where is this from
 */
function sleek_get_neighbouring_array_element ($array, $orig, $offset) {
	$keys = array_keys($array);

	return $array[$keys[array_search($orig, $keys) + $offset]];
}

/**
 * Returns a full navigation tree based on a page
 */
function sleek_get_sub_nav_tree ($post) {
	$allfather = $post;

	if (is_page($post)) {
		if ($post->post_parent) {
			$parent = get_page($post->post_parent);

			while ($parent->post_parent) {
				$parent = get_page($parent->post_parent);
			}

			$allfather = $parent;
			$children = wp_list_pages('title_li=&child_of=' . $parent->ID . '&echo=0&link_before=&link_after=');
		}
		else {
			$children = wp_list_pages('title_li=&child_of=' . $post->ID . '&echo=0&link_before=&link_after=');
		}
	}

	$title = $allfather->post_title;
	$url = get_permalink($allfather->ID);

	return [
		'title'		=> $title,
		'url'		=> $url,
		'allfather'	=> $allfather,
		'children'	=> $children
	];
}

/**
 * Returns current page URL (with or without ?query)
 * NOTE: Where is this from?? It's oooold
 */
function sleek_curr_page_url ($withQry = true) {
	$isHTTPS	= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on');
	$port		= '';

	# NOTE: Causes issues with HTTPS!
#	$port		= (isset($_SERVER['SERVER_PORT']) && ((!$isHTTPS && $_SERVER['SERVER_PORT'] != '80') || ($isHTTPS && $_SERVER['SERVER_PORT'] != '443')));
#	$port		= ($port) ? ':' . $_SERVER['SERVER_PORT'] : '';

	$url		= ($isHTTPS ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
	$qryStart	= strpos($url, '?');

	if ($qryStart and !$withQry) {
		return substr($url, 0, $qryStart);
	}

	return $url;
}

/**
 * Appens (or replaces) $query to current query string
 */
function sleek_append_to_query_string ($query) {
	parse_str($_SERVER['QUERY_STRING'], $queryString);
	parse_str($query, $newQueryString);

	return http_build_query(array_merge($queryString, $newQueryString));
}

/**
 * Includes and returns contents instead of echo:ing
 */
function sleek_fetch ($f, $vars = false) {
	if ($vars) {
		extract($vars);
	}

	ob_start();

	include $f;

	$contents = ob_get_contents();

	ob_end_clean();

	return $contents;
}
