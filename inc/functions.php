<?php
function get_posts_by_simple_fields_value ($args, $postType = 'any') {
	$rows = get_posts(array(
		'post_type' => $postType, 
		'numberposts' => -1
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

function debug ($foo) {
	header('Content-type: text/plain; charset=utf-8');
	var_dump($foo);
	die;
}

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

# Ignore categories that start with an underscore
function h5b_the_category ($i, $echo = true, $prefix = '_') {
	global $post;

	if ($post) {
		$id = $post->ID;
	}
	else {
		$id = $i;
	}

	$catIDs = wp_get_post_categories($id);

	if (!count($catIDs)) {
		return;
	}

	$allCats	= get_categories(array('include' => implode(',', $catIDs)));
	$cats		= array();

	foreach ($allCats as $cat) {
		if (substr($cat->slug, 0, 1) != $prefix) {
			$cats[] = $cat;
		}
	}

	$html = '<ul>';

	foreach ($cats as $cat) {
		$html .= '<li class="' . $cat->slug . '"><a href="' . get_category_link($cat->cat_ID) . '">' . htmlspecialchars($cat->name) . '</a></li>';
	}

	$html .= '</ul>';

	if ($echo) {
		echo $html;
	}
	else {
		return $html;
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
function redirectToReferrer ($append = false) {
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

# Appends 'what' to query string
function appendToQryStr ($what) {
	$qryStr = $_SERVER['QUERY_STRING'];

	if ($qryStr) {
		$newVars = explode('&', $what);

		foreach ($newVars as $var) {
			list($key, $val)	= explode('=', $var);
			$regExp				= "/$key=.*?(&|$)/";

			if (preg_match($regExp, $qryStr)) {
				$qryStr = preg_replace($regExp, "$key=$val" . '$1', $qryStr);
			}
			else {
				$qryStr .= "&$key=$val";
			}
		}
	}
	else {
		$qryStr = $what;
	}

	return '?' . $qryStr;
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

# These are used with the attachments-plugin
function get_img_attachments ($id) {
	if (!function_exists('attachments_get_attachments')) {
		return false;
	}

	$tmp = attachments_get_attachments($id);
	$atts = array();

	foreach ($tmp as $att) {
		if (substr($att['mime'], 0, 5) == 'image') {
			$atts[] = $att;
		}
	}

	return count($atts) ? $atts : false;
}

function get_non_img_attachments ($id) {
	if (!function_exists('attachments_get_attachments')) {
		return false;
	}

	$tmp = attachments_get_attachments($id);
	$atts = array();

	foreach ($tmp as $att) {
		if (substr($att['mime'], 0, 5) != 'image') {
			$atts[] = $att;
		}
	}

	return count($atts) ? $atts : false;
}
