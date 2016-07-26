<?php
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
 * Returns array of users with certain $roles
 */
function sleek_get_users_by_role ($roles) {
	$user_query = new WP_User_Query([
		'role__in' => $roles
	]);

	return $user_query->results;
}

/**
 * Gets the first thumbnail from a list of posts
 * TODO: Should check if has_post_thumbnail and return first one that exists
 */
function sleek_get_first_post_thumbnail_url ($rows, $size) {
	global $post;

	setup_postdata($rows[0]);

	$url = the_post_thumbnail_url($size);

	wp_reset_postdata();

	return $url;
}

/**
 * Returns an array of category names for a given post ID
 */
function sleek_get_category_names_by_post_id ($id) {
	$tmp = get_the_category($id);
	$postCats = [];

	foreach ($tmp as $t) {
		$postCats[] = $t->cat_name;
	}

	return $postCats;
}

/**
 * Returns an array of category links for a given post ID
 */
function sleek_get_category_links_by_post_id ($id) {
	$tmp = get_the_category($id);
	$postCats = [];

	foreach ($tmp as $t) {
		$postCats[] = '<a href="' . get_term_link($t) . '">' . $t->cat_name . '</a>';
	}

	return $postCats;
}

/**
 * Similar to locate_template but looks for templates named
 * section--modifier-1--modifier--2.php then section--modifier-1.php then finally section.php
 */
function sleek_locate_acf_section_template ($section, $modifiers) {
	$modifiers = $modifiers ? explode(' ', $modifiers) : [];
	$numModifiers = count($modifiers);

	for ($i = 0; $i < $numModifiers; $i++) {
		$templateName = 'modules/acf-sections/' . $section . '--' . implode('--', $modifiers);

		if (locate_template($templateName . '.php')) {
			return $templateName;
		}
		else {
			array_pop($modifiers);
		}
	}

	$templateName = 'modules/acf-sections/' . $section;

	if (locate_template($templateName . '.php')) {
		return $templateName;
	}

	return false;
}

/**
 * Search a multidimensional array for key/value
 *
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

# Return image URL by ID
/**
 * Return image URL by attacment ID
 * (like the_post_thumbnail_url but GET_post_thumbnail_url -
 * why the HELL did they add one and not the other? :P)
 * TODO: It IS added :P https://developer.wordpress.org/reference/functions/get_the_post_thumbnail_url/
 */
function sleek_get_img_src_by_id ($id, $size = 'full') {
	if ($id) {
		$imgSrc = wp_get_attachment_image_src($id, $size);

		if ($imgSrc) {
			return $imgSrc[0];
		}
	}

	return false;
}

/**
 * Limit str's length to limit words
 *
 * http://stackoverflow.com/questions/965235/how-can-i-truncate-a-string-to-the-first-20-words-in-php#answer-965343
 */
function sleek_limit_words ($str, $limit) {
	return trim(preg_replace('/((\w+\W*){' . ($limit + 1) . '}(\w+))(.*)/', '${1}', $str));
}

/**
 * Returns array of social media URLs and titles
 */
function sleek_get_social_media_links () {
	$links = [];

	$links[] = [
		'title' => 'Facebook',
		'url' => '//www.facebook.com/sharer/sharer.php?u={url}&t={title}'
	];
	$links[] = [
		'title' => 'Twitter',
		'url' => '//twitter.com/intent/tweet?url={url}&text={title}'
	];
	$links[] = [
		'title' => 'LinkedIn',
		'url' => '//www.linkedin.com/shareArticle?mini=true&url={url}&title={title}&summary=&source=' . home_url('/')
	];

	for ($i = 0; $i < count($links); $i++) {
		$links[$i]['url'] = str_replace(['{url}', '{title}'], [urlencode(sleek_curr_page_url(false)), urlencode(wp_title('|', false, 'right')]), $links[$i]['url']);
		$links[$i]['slug'] = sanitize_title($links[$i]['title']);
	}

	return $links;
}

/**
 * Returns the avatar URL only from the return value of get_avatar($userID, $size)
 *
 * http://wordpress.stackexchange.com/questions/59442/how-do-i-get-the-avatar-url-instead-of-an-html-img-tag-when-using-get-avatar
 */
function sleek_get_avatar_url ($get_avatar) {
	preg_match("/src='(.*?)'/i", $get_avatar, $matches);

	return $matches[1];
}

/**
 * Like get_template_part but accepts arguments
 */
function sleek_get_template_part ($path, $args = []) {
	if ($locatedPath = locate_template($path . '.php')) {
		extract($args);

		include $locatedPath;
	}
	else {
		echo "[ No such module: $path ]";
	}
}

/**
 * Returns neighbouring array element with optional offset
 */
function sleek_get_neighbouring_array_element ($array, $orig, $offset) {
	$keys = array_keys($array);

	return $array[$keys[array_search($orig, $keys) + $offset]];
}

/**
 * Returns a full navigation tree based on a post
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
 * Gets a post based on its simple field value (the plugin)
 */
function sleek_get_posts_by_simple_fields_value ($args, $postType = 'any') {
	$rows = get_posts([
		'post_type'		=> $postType,
		'numberposts'	=> -1
	]);
	$return = [];

	foreach ($rows as $row) {
		$valueGroups = simple_fields_values($args['key'], $row->ID);

		if ($valueGroups) {
			foreach ($valueGroups as $values) {
				if ($values) {
					foreach ($values as $value) {
						if ($value == $args['value']) {
							$return[] = $row;
						}
					}
				}
			}
		}
	}

	return count($return) ? $return : false;
}

/**
 * Returns image ID based on filename
 */
function sleek_get_image_id_by_filename ($filename) {
	global $wpdb;

	$filename	= preg_replace("/\\.[^.\\s]{3,4}$/", '', $filename);
	$result		= $wpdb->get_col($wpdb->prepare("SELECT ID FROM {$wpdb->prefix}posts WHERE post_name = '%s';", $filename));

	if ($result) {
		return $result[0];
	}
	else {
		return null;
	}
}

/**
 * Returns post excerpt based on post ID
 */
function sleek_get_the_excerpt ($post_id) {
	global $post;

	$post = get_post($post_id);

	setup_postdata($post);

	ob_start();

	the_excerpt();

	$output = ob_get_contents();

	ob_end_clean();

	wp_reset_postdata();

	return $output;
}

/**
 * Returns current page URL (with or without ?query)
 */
function sleek_curr_page_url ($withQry = true) {
	$isHTTPS	= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on');
	$port		= (isset($_SERVER['SERVER_PORT']) && ((!$isHTTPS && $_SERVER['SERVER_PORT'] != '80') || ($isHTTPS && $_SERVER['SERVER_PORT'] != '443')));
	$port		= ($port) ? ':' . $_SERVER['SERVER_PORT'] : '';
	$url		= ($isHTTPS ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
	$qryStart	= strpos($url, '?');

	if ($qryStart and !$withQry) {
		return substr($url, 0, $qryStart);
	}

	return $url;
}

# Redirects and dies
/**
 * Redirects to $to and dies
 */
function sleek_redirect ($to) {
	header('Location: ' . $to);
	die('Redirect failed, please go to <a href="' . $to . '">' . $to . '</a>');
}

/**
 * Redirects to referrer and adds an optional query parameter
 */
function sleek_redirect_back ($append = false) {
	$ref = $_SERVER['HTTP_REFERER'];

	if ($append) {
		if (stristr($ref, '?')) {
			$ref = "$ref&$append";
		}
		else {
			$ref = "$ref?$append";
		}
	}

	redirect($ref);
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
