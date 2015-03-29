<?php
# http://wordpress.stackexchange.com/questions/59442/how-do-i-get-the-avatar-url-instead-of-an-html-img-tag-when-using-get-avatar
function sleek_get_avatar_url ($get_avatar) {
	preg_match("/src='(.*?)'/i", $get_avatar, $matches);

	return $matches[1];
}

function sleek_get_module ($mod, $args = array()) {
	$path = get_stylesheet_directory() . '/modules/' . $mod . '.php';
	$path = file_exists($path) ? $path : get_template_directory() . '/modules/' . $mod . '.php';

	if (file_exists($path)) {
		extract($args);

		include $path;
	}
	else {
		echo "[ No such module: $mod ]";
	}
}

function sleek_get_neighbouring_array_element ($array, $orig, $offset) {
	$keys = array_keys($array);

	return $array[$keys[array_search($orig, $keys) + $offset]];
}

function sleek_get_sub_nav_tree ($post) {
	if (is_page($post)) {
		if ($post->post_parent) {
			$parent = get_page($post->post_parent);

			while ($parent->post_parent) {
				$parent = get_page($parent->post_parent);
			}

			$children = wp_list_pages('title_li=&child_of=' . $parent->ID . '&echo=0&link_before=&link_after=');
			$title = $parent->post_title;
			$url = get_permalink($parent->ID);
		}
		else {
			$children = wp_list_pages('title_li=&child_of=' . $post->ID . '&echo=0&link_before=&link_after=');
			$title = $post->post_title;
			$url = get_permalink($post->ID);
		}
	}

	return array(
		'title'		=> $title, 
		'url'		=> $url, 
		'children'	=> $children
	);
}

# Gets a post based on its simple field value (the plugin)
function get_posts_by_simple_fields_value ($args, $postType = 'any') {
	$rows = get_posts(array(
		'post_type'		=> $postType, 
		'numberposts'	=> -1
	));
	$return = array();

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

# Debug
function debug ($foo) {
	header('Content-type: text/plain; charset=utf-8');

	var_dump($foo);

	die;
}

# Gets image ID by filename
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

# Gets the excerpt by ID
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

# Returns the current page URL
function curr_page_url ($withQry = true) {
	$isHTTPS	= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on');
	$port		= (isset($_SERVER['SERVER_PORT']) && ((!$isHTTPS && $_SERVER['SERVER_PORT'] != "80") || ($isHTTPS && $_SERVER['SERVER_PORT'] != '443')));
	$port		= ($port) ? ':' . $_SERVER['SERVER_PORT'] : '';
	$url		= ($isHTTPS ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'] . $port . $_SERVER['REQUEST_URI'];
	$qryStart	= strpos($url, '?');

	if ($qryStart and !$withQry) {
		return substr($url, 0, $qryStart);
	}

	return $url;
}

# Redirects and dies
function redirect ($to) {
	header('Location: ' . $to);
	die('Redirect failed, please go to <a href="' . $to . '">' . $to . '</a>');
}

# Redirects to referrer
function redirect_back ($append = false) {
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

# Includes and returns contents instead of echo:ing
function fetch ($f, $vars = false) {
	if ($vars) {
		extract($vars);
	}

	ob_start();

	include $f;

	$contents = ob_get_contents();

	ob_end_clean();

	return $contents;
}
