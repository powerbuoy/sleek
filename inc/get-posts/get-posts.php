<?php
/**
 * Get posts
 * TODO: Write docs
 */
# add_shortcode('get-posts', 'sleek_shortcode_get_posts');

function sleek_shortcode_get_posts ($atts) {
	# Set some vars
	$path		= get_template_directory() . '/inc/get-posts/';
	$type		= isset($atts['type']) ? (strpos($atts['type'], ',') ? explode(',', $atts['type']) : $atts['type']) : 'post';
	$limit		= isset($atts['limit']) ? $atts['limit'] : -1;
	$order		= isset($atts['order']) ? $atts['order'] : 'post_date';
	$template	= (isset($atts['template']) and file_exists($path . basename($atts['template']) . '.php')) ? basename($atts['template']) : 'list-posts';

	$empty		= isset($atts['empty']) ? $atts['empty'] : __('No posts found.', 'sleek');
	$show		= isset($atts['show']) ? explode(',', $atts['show']) : false;
	$hide		= isset($atts['hide']) ? explode(',', $atts['hide']) : false;

	$parent		= isset($atts['parent']) ? (strlen($atts['parent']) ? $atts['parent'] : get_the_id()) : false;

	# Create show/hide bools ($show_date, $show_title etc (instead of complex if:s in template))
	# TODO

	# Create get_posts args
	$args = array(
		'post_type'		=> $type, 
		'numberposts'	=> $limit, 
		'orderby'		=> $order, 
		'supress_filters' => false # Fix for WPML returning all languages
	);

	# Include/exclude
	if (isset($atts['include'])) {
		$args['post__in'] = strpos($atts['include'], ',') ? explode(',', $atts['include']) : array($atts['include']);
	}

	if (isset($atts['exclude'])) {
		$args['post__not_in'] = strpos($atts['exclude'], ',') ? explode(',', $atts['exclude']) : array($atts['exclude']);
	}

	# Loop through $tax_-vars and create taxonomy query
	$tax_query = array();

	foreach ($atts as $k => $v) {
		if (strpos($k, 'tax_') === 0) {
			$tax_query[] = array(
				'taxonomy'	=> substr($k, 4), 
				'field'		=> 'slug', # TODO: check if int and use id instead
				'terms'		=> $v
			);
		}
	}

	$args['tax_query'] = $tax_query;

	# Check if a particular parent should be used
	if ($parent) {
		$args['post_parent'] = $parent; # TODO: Might just want direct children? (or separate "dad"-argument?) + might want array of parent/dad?
	}

	# Fetch posts
	$rows = get_posts($args);

	# If title is asked for, but set to 1 - generate a title or use a default one
	if (isset($atts['title']) and $atts['title'] == 1) {
		# Set to post type
		$atts['title'] = __(ucfirst(str_replace('_', ' ', $type)), 'sleek');

		# If there is only one tax_query set, use its title
		if (count($tax_query) === 1) {
			$term = get_term_by('slug', $tax_query[0]['terms'], $tax_query[0]['taxonomy']);

			$atts['title'] = $term->name;
		}
	}

	# Work out the number of columns to display posts in (whether template author decides to USE this is up to him)
	# TODO: Should be able to pass in [get-posts cols=3]

	if (isset($atts['cols'])) {
		$cols = $atts['cols'];
	}
	else {
		$cols = $limit;
		$cols = ($cols == -1) ? count($rows) : $cols;
		# $cols = ($cols > 4) ? TODO : $cols; # If limit exceeds 4 or so cols should be set to something appropriate (like limit=9 cols=3 etc, limit=8 cols=4)
	}

	# Set a default image size
	$img_size = isset($atts['img_size']) ? $atts['img_size'] : 'sleek-medium';

	# Work out the archive URL for this post type (TODO: if a particular tax is set - limit to it)
	$archive_url = false;

	if ($type == 'post') {
		$archive_url = (get_option('show_on_front') == 'page') ? get_permalink(get_option('page_for_posts')) : bloginfo('url');
	}
	elseif ($type != 'page') {
		$archive_url = get_post_type_archive_link($type);
	}

	# If one tax query is set - get its URL instead
	if (count($tax_query) === 1) {
		$term = get_term_by('slug', $tax_query[0]['terms'], $tax_query[0]['taxonomy']);

		if ($term) {
			$archive_url = get_term_link($term);
		}
	}

	# Fetch the template - pass in all args sent through shortcode + some we've created
	if (!$rows) {
		return false; # 'No posts found';
	}
	else {
		return fetch("$path$template.php", array_merge($atts, array(
			'sql'			=> $GLOBALS['wp_query']->request, 
			'rows'			=> $rows, 
			'limit'			=> $limit, 
			'type'			=> $type, 
			'order'			=> $order, 
			'empty'			=> $empty, 
			'show'			=> $show, 
			'hide'			=> $hide, 
			'cols'			=> $cols, 
			'archive_url'	=> $archive_url, 
			'args'			=> $args, 
			'atts'			=> $atts
		)));
	}
}
