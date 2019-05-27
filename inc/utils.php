<?php
function sleek_get_yoast_social_links () {
	$tmp = get_option('wpseo_social');
	$links = [];
	$nicenames = [
		'linkedin' => 'LinkedIn',
		'youtube' => 'YouTube',
		'google_plus' => 'Google+'
	];

	if ($tmp and count($tmp)) {
		foreach ($tmp as $k => $v) {
			# Only grab non empty URLs or "sites"
			if ((substr($k, -3) === 'url' or substr($k, -4) === 'site') and !empty($v)) {
				$url = $k === 'twitter_site' ? 'https://twitter.com/' . $v : $v;
				$name = substr($k, -3) === 'url' ? $name = substr($k, 0, -4) : $name = substr($k, 0, -5);
				$name = isset($nicenames[$name]) ? $nicenames[$name] : ucfirst(str_replace(['_', '-'], ' ', $name));

				$links[] = [
					'name' => $name,
					'url' => $url
				];
			}
		}
	}

	return $links;
}

function sleek_optimal_col_count ($numItems, $maxCols = 4) {
	$numCols = $numItems;

	if ($numCols > $maxCols and $maxCols === 2) {
		$numCols = 2;
	}
	elseif ($numCols > $maxCols) {
		$numCols = sqrt($numItems);

		if (!is_int($numCols) or $numCols > $maxCols) {
			$numCols = -1;

			for ($i = $maxCols; $i > 2; $i--) {
				if ($numItems % $i === 0) {
					$numCols = $i;

					break;
				}
			}

			if ($numCols === -1) {
				$rests = [];

				for ($i = $maxCols; $i > 2; $i--) {
					$rests[$i] = $numItems % $i;
				}

				$numCols = array_search(max($rests), $rests);
			}
		}
	}

	return $numCols;
}


# https://stackoverflow.com/questions/8586141/implode-array-with-and-add-and-before-last-item
function sleek_implode_and ($array, $glue = ', ', $lastGlue = ' & ') {
	return join($lastGlue, array_filter(array_merge(array(join($glue, array_slice($array, 0, -1))), array_slice($array, -1)), 'strlen'));
}

# https://stackoverflow.com/questions/1534127/pluralize-in-php
function sleek_pluralize ($singular) {
	$last = strtolower($singular[strlen($singular) - 1]);

	if ($last == 'y') {
		return substr($singular, 0, -1) . 'ies';
	}
	elseif ($last == 's') {
		return $singular . 'es';
	}
	else {
		return $singular . 's';
	}
}

/**
 * Attempts to return the currently viewed post type
 */
function sleek_get_current_post_type () {
	$pt = false;

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
	# Taxonomy term
	elseif ($qo instanceof WP_Term) {
		$tax = get_taxonomy($qo->taxonomy);
		$pt = $tax->object_type[0];
	}
	# Post type set in query var
	elseif (get_query_var('post_type')) {
		$pt = get_query_var('post_type');

		if (is_array($pt)) {
			$pt = '__mixed';
		}
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

	if ($post->post_parent) {
		$parent = get_post($post->post_parent);

		while ($parent->post_parent) {
			$parent = get_post($parent->post_parent);
		}

		$allfather = $parent;
		$children = wp_list_pages([
			'post_type' => $post->post_type,
			'child_of' => $parent->ID,
			'echo' => false,
			'link_before' => '',
			'link_after' => '',
			'title_li' => ''
		]);
	}
	else {
		$children = wp_list_pages([
			'post_type' => $post->post_type,
			'child_of' => $post->ID,
			'echo' => false,
			'link_before' => '',
			'link_after' => '',
			'title_li' => ''
		]);
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
 * Like get_template_part but accepts arguments
 * NOTE: Never pass in any of the reserved query vars!
 * https://codex.wordpress.org/WordPress_Query_Vars
 */
function sleek_get_template_part ($path, $suffix = null, $args = []) {
	foreach ($args as $k => $v) {
		set_query_var($k, $v);
	}

	get_template_part($path, $suffix);
}

/**
 * Like get_template_part but accepts arguments and doesn't echo
 * NOTE: Never pass in any of the reserved query vars!
 * https://codex.wordpress.org/WordPress_Query_Vars
 */
function sleek_fetch_template_part ($path, $args = []) {
	foreach ($args as $k => $v) {
		set_query_var($k, $v);
	}

	ob_start();

	get_template_part($path);

	$contents = ob_get_clean();

	return $contents;
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

	$contents = ob_get_clean();

	return $contents;
}
