<?php
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
function h5b_get_image_id_by_filename ($filename) {
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
function h5b_get_the_excerpt ($post_id) {
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
