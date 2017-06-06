<?php
/**
 * Returns valuable data such as title/description  based on the currently
 * viewed type of archive (cpt, blog, category, date, search etc)
 * TODO: Never assume that get_post_type_object() returns an object!
 */
function sleek_get_archive_data ($args = []) {
	global $post;
	global $wp_query;

	# WPML Support
	$lang = defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : '';

	# Args
	$args = array_merge([
		'image_size' => 'full',
		'date_formats' => [
			'yearly' => 'Y',
			'monthly' => 'F Y',
			'daily' => 'l, F j, Y'
		]
	], $args);

	# Return data
	$data = [
		'title' => false,
		'post_type_title' => false,
		'content' => false,
		'image' => false,
		'image_id' => false,
		'post_type' => false
	];

	# The normal blog archive when using a static home page (TODO: Add support for NONE static home page)
	if (is_home() and get_option('page_for_posts')) {
		$data['post_type'] = 'post';
		$data['post_type_title'] = get_the_title(get_option('page_for_posts'));
		$data['title'] = get_the_title(get_option('page_for_posts'));
		$data['content'] = apply_filters('the_content', get_post_field('post_content', get_option('page_for_posts')));
		$data['image'] = has_post_thumbnail(get_option('page_for_posts')) ? get_the_post_thumbnail_url(get_option('page_for_posts'), $args['image_size']) : false;
		$data['image_id'] = get_post_thumbnail_id(get_option('page_for_posts'));
	}

	# A blog category
	elseif (is_category()) {
		$term = get_category(get_query_var('cat'));

		$data['post_type'] = 'post';
		$data['post_type_title'] = get_the_title(get_option('page_for_posts'));
		$data['title'] = $term->name;
		$data['content'] = wpautop($term->description);
		$data['image'] = has_post_thumbnail(get_option('page_for_posts')) ? get_the_post_thumbnail_url(get_option('page_for_posts'), $args['image_size']) : false;
		$data['image_id'] = get_post_thumbnail_id(get_option('page_for_posts'));
	}

	# A blog tag
	elseif (is_tag()) {
		$term = get_term_by('slug', get_query_var('tag'), 'post_tag');

		$data['post_type'] = 'post';
		$data['post_type_title'] = get_the_title(get_option('page_for_posts'));
		$data['title'] = $term->name;
		$data['content'] = wpautop($term->description);
		$data['image'] = has_post_thumbnail(get_option('page_for_posts')) ? get_the_post_thumbnail_url(get_option('page_for_posts'), $args['image_size']) : false;
		$data['image_id'] = get_post_thumbnail_id(get_option('page_for_posts'));
	}

	# Date blog archives
	elseif (is_year() or is_month() or is_day()) {
		$data['post_type'] = 'post';
		$data['post_type_title'] = get_the_title(get_option('page_for_posts'));
		$data['image'] = has_post_thumbnail(get_option('page_for_posts')) ? get_the_post_thumbnail_url(get_option('page_for_posts'), $args['image_size']) : false;
		$data['image_id'] = get_post_thumbnail_id(get_option('page_for_posts'));

		if (is_year()) {
			$data['title'] = sprintf(__('Yearly archives', 'sleek'));
			$data['content'] = wpautop(get_the_time($args['date_formats']['yearly']));
		}
		elseif (is_month()) {
			$data['title'] = sprintf(__('Monthly archives', 'sleek'));
			$data['content'] = wpautop(get_the_time($args['date_formats']['monthly']));
		}
		else {
			$data['title'] = sprintf(__('Daily archives', 'sleek'));
			$data['content'] = wpautop(get_the_time($args['date_formats']['daily']));
		}
	}

	# Search
	elseif (is_search()) {
		# With results
		if (have_posts()) {
			# Non-empty search
			if (strlen(trim(get_search_query())) > 0) {
				$title		= sprintf(__('Search results (%s) for: <strong>"%s"</strong>', 'sleek'), $wp_query->found_posts, get_search_query());

				$total		= $wp_query->found_posts;
				$currPage	= $wp_query->query_vars['paged'] ? $wp_query->query_vars['paged'] : 1;
				$numPerPage	= $wp_query->query_vars['posts_per_page'];
				$resFrom	= ($currPage * $numPerPage - $numPerPage) + 1;
				$resTo		= ($resFrom + $numPerPage) - 1;
				$resTo		= $resTo > $total ? $total : $resTo;

				$content	= '<p>' . sprintf(__('Displaying results %d through %d', 'sleek'), $resFrom, $resTo) . '</p>';
			}
			# An empty search
			else {
				$title		= sprintf(__('Empty search', 'sleek'), $wp_query->found_posts, get_search_query());
				$content	= '<p>' . __("You didn't search for anything in particular so I'm showing you everything", 'sleek') . '</p>';
			}
		}
		# No search results
		else {
			$title		= sprintf(__('No search results for: <strong>"%s"</strong>', 'sleek'), get_search_query());
			$content	= '<p>' . __("We couldn't find any matching search results for your query.", 'sleek') . '</p>';
		}

		$data['title'] = $title;
		$data['content'] = $content;

		# If searching a specific PT, fetch its data
		# TODO: Create function for fetching this PT data as it's now used in is_search, is_tax AND is_pt_archive
		if (isset($_GET['post_type'])) {
			$postType = get_post_type_object($_GET['post_type']);

			if ($postType) {
				$data['post_type'] = $_GET['post_type'];
				$data['post_type_title'] = $postType->labels->name;

				if ($imageId = get_option($data['post_type'] . $lang . '_image')) {
					$data['image'] = wp_get_attachment_image_src($imageId, $args['image_size'])[0];
					$data['image_id'] = $imageId;
				}
				if ($title = get_option($data['post_type'] . $lang . '_title')) {
					$data['post_type_title'] = $title;
				}
			}
		}
	}

	# Custom taxonomy term
	elseif (is_tax()) {
		$term = $wp_query->get_queried_object();
		$postType = get_post_type_object(get_post_type());

		$data['post_type'] = get_post_type();
		$data['post_type_title'] = $postType->labels->name;
		$data['title'] = $term->name;
		$data['content'] = wpautop($term->description);

		if ($imageId = get_option($data['post_type'] . $lang . '_image')) {
			$data['image'] = wp_get_attachment_image_src($imageId, $args['image_size'])[0];
			$data['image_id'] = $imageId;
		}
		if ($title = get_option($data['post_type'] . $lang . '_title')) {
			$data['post_type_title'] = $title;
		}
	}

	# Post type archive
	elseif (is_post_type_archive()) {
		$postType = get_post_type_object($wp_query->query['post_type']);

		$data['post_type'] = $wp_query->query['post_type'];
		$data['post_type_title'] = $postType->labels->name;
		$data['title'] = $postType->labels->name;
		$data['content'] = $postType->description ? wpautop($postType->description) : false;

		if ($title = get_option($data['post_type'] . $lang . '_title')) {
			$data['post_type_title'] = $data['title'] = $title;
		}
		if ($description = get_option($data['post_type'] . $lang . '_description')) {
			$data['content'] = wpautop($description);
		}
		if ($imageId = get_option($data['post_type'] . $lang . '_image')) {
			$data['image'] = wp_get_attachment_image_src($imageId, $args['image_size'])[0];
			$data['image_id'] = $imageId;
		}
	}

	# Author
	elseif (is_author()) {
		if (get_query_var('author_name')) {
			$usr = get_user_by('slug', get_query_var('author_name'));
		}
		else {
			$usr = get_user_by('id', get_query_var('author'));
		}

		if (!$usr) {
			$usr = get_user_by('id', get_the_author_meta('ID'));
		}

		$description = get_user_meta($usr->ID, 'description', true);

		$data['username'] = $usr->display_name;
		$data['url'] = $usr->user_url;
		$data['title'] = sprintf(__('Posts by <strong>%s</strong>', 'sleek'), $usr->display_name);
		$data['content'] = wpautop($description);

		# Get requested thumbnail size's width
		global $_wp_additional_image_sizes;

		if (isset($_wp_additional_image_sizes[$args['image_size']])) {
			$size = $_wp_additional_image_sizes[$args['image_size']]['width'];
		}
		else {
			$size = 640;
		}

		$data['image'] = get_avatar_url($usr->ID, [
			'size' => $size
		]);
	}

	return $data;
}

/**
 * Returns list of all taxonomies associated with $args['post_type']
 */
function sleek_get_post_type_taxonomies ($args = []) {
	# Work out the post type on this archive
	$qo = get_queried_object();

	if ($qo instanceof WP_Post_Type) {
		$pt = $qo->name;
	}
	elseif ($qo instanceof WP_Post) {
		$pt = 'post';
	}
	else {
		$pt = get_post_type();
	}

	# Default args
	$args = array_merge([
		'post_type' => $pt,
		'hide_empty' => true
	], $args);

	$pt = $args['post_type'];

	# Get all taxonomies associated with this PT
	$taxonomies = get_object_taxonomies($args['post_type'], 'objects');
	$data = [];

	# We need to rewrite some (built in) taxonomies
	$taxRewrite = [
		'category' => [
			'name' => 'cat',
			'property' => 'term_id'
		],
		'post_tag' => [
			'name' => 'tag'
		]
	];

	# Loop through them all
	foreach ($taxonomies as $tax) {
		$hasSelected = false; # Whether this taxonomy has any selected terms
		$taxQueryName = $tax->name; # The get_query_var name of this taxonomy (usually the same as tax name but not for built in taxonomies...)
		$taxQueryProperty = 'slug'; # The property stored on the query var (usually slug but not for category... fucking WordPress)

		# Rewrite query name and property for certain taxonomies
		if (isset($taxRewrite[$tax->name])) {
			$taxQueryName = isset($taxRewrite[$tax->name]['name']) ? $taxRewrite[$tax->name]['name'] : $taxQueryName;
			$taxQueryProperty = isset($taxRewrite[$tax->name]['property']) ? $taxRewrite[$tax->name]['property'] : $taxQueryProperty;
		}

		# Get all the terms
		$terms = [];
		$tmp = get_terms([
			'taxonomy' => $tax->name,
			'hide_empty' => $args['hide_empty']
		]);

		# Only continue if we have terms
		if ($tmp) {
			foreach ($tmp as $term) {
				# Store additional data about each term
				$term = [
					'term' => $term, # The original term
					'permalink' => get_term_link($term), # Permalink to term page
					'selected' => $term->{$taxQueryProperty} == get_query_var($taxQueryName)
				];

				# Remember if we have a selected term in this tax
				if ($term['selected']) {
					$hasSelected = true;
				}

				# Store the term
				$terms[] = $term;
			}

			# Store the taxonomy
			$data[] = [
				'taxonomy' => $tax,
				'has_selected' => $hasSelected,
				'post_type' => $args['post_type'],
				'post_type_archive_link' => get_post_type_archive_link($args['post_type']),
				'terms' => $terms
			];
		}
	}

	return $data;
}

/**
 * Returns list of all taxonomies associated with $args['post_type']
 * along with data used for displaying said taxonomies in a form
 */
function sleek_get_post_type_taxonomy_filter ($args = []) {
	# Work out the post type on this archive
	$qo = get_queried_object();

	if ($qo instanceof WP_Post_Type) {
		$pt = $qo->name;
	}
	elseif ($qo instanceof WP_Post) {
		$pt = 'post';
	}
	else {
		$pt = get_post_type();
	}

	# Default args
	$args = array_merge([
		'post_type' => $pt,
		'hide_empty' => true
	], $args);

	$pt = $args['post_type'];

	# Get all taxonomies associated with this PT
	$taxonomies = get_object_taxonomies($args['post_type'], 'objects');
	$data = [];

	# Go through them all
	foreach ($taxonomies as $tax) {
		$hasSelected = false; # Whether this taxonomy has any terms selected
		$taxQueryName = 'sleek_filter_taxonomy_' . $tax->name; # Name of ?get parameter

		# Get all the terms
		$terms = [];
		$tmp = get_terms([
			'taxonomy' => $tax->name,
			'hide_empty' => $args['hide_empty']
		]);

		# Only continue if we have terms
		if ($tmp) {
			foreach ($tmp as $term) {
				$isSelected = false;

				# See if this term is selected
				if (isset($_GET[$taxQueryName]) and is_array($_GET[$taxQueryName])) {
					$isSelected = in_array($term->slug, $_GET[$taxQueryName]) ? true : false;
				}
				else {
					$isSelected = (isset($_GET[$taxQueryName]) and $term->slug == $_GET[$taxQueryName]) ? true : false;
				}

				# Store additional data about the term
				$term = [
					'term' => $term,
					'query_name' => $taxQueryName,
					'query_value' => $term->slug,
					'selected' => $isSelected
				];

				# Remember if this tax had any selected terms
				if ($isSelected) {
					$hasSelected = true;
				}

				# Store the term
				$terms[] = $term;
			}

			# Store the taxonomy
			$data[] = [
				'taxonomy' => $tax,
				'has_selected' => $hasSelected,
				'post_type' => $args['post_type'],
				'query_name' => $taxQueryName,
				'query_value' => '',
				'terms' => $terms
			];
		}
	}

	return $data;
}

# Add support for filtering on sleek_filter_* parameters
add_filter('pre_get_posts', function ($query) {
	if (!is_admin() and $query->is_main_query()) {
		# Build potential tax query
		$taxQuery = ['relation' => 'AND']; # TODO: Shouldn't be hard coded?
		$hasTaxQuery = false;

		# Go through all get params
		foreach ($_GET as $k => $v) {
			# If this is a sleek filter param
			if (substr($k, 0, strlen('sleek_filter_taxonomy_')) == 'sleek_filter_taxonomy_') {
				$tax = substr($k, strlen('sleek_filter_taxonomy_'));
				$val = $_GET[$k];

				if ($val) {
					$hasTaxQuery = true;
					$taxQuery[] = [
						'taxonomy' => $tax,
						'field' => 'slug',
						'terms' => $val
					];
				}
			}
		}

		if ($hasTaxQuery) {
			$query->set('tax_query', $taxQuery);
		}

		# See if a search string is provided
		if (isset($_GET['sleek_filter_search'])) {
			$query->set('s', $_GET['sleek_filter_search']);
		}
	}
});
