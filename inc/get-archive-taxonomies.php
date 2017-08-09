<?php
function sleek_get_archive_post_type () {
	# Work out the post type on this archive
	$qo = get_queried_object();

	# Post type archive
	if ($qo instanceof WP_Post_Type) {
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
 * Returns list of all taxonomies associated with $args['post_type']
 */
function sleek_get_post_type_taxonomies ($args = []) {
	# Default args
	$args = array_merge([
		'post_type' => sleek_get_archive_post_type(),
		'hide_empty' => true
	], $args);

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
		$hasActive = false; # Whether this taxonomy has any active terms
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
					'active' => $term->{$taxQueryProperty} == get_query_var($taxQueryName)
				];

				# Remember if we have a active term in this tax
				if ($term['active']) {
					$hasActive = true;
				}

				# Store the term
				$terms[] = $term;
			}

			# Store the taxonomy
			$data[] = [
				'taxonomy' => $tax,
				'has_active' => $hasActive,
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
	# Default args
	$args = array_merge([
		'post_type' => sleek_get_archive_post_type(),
		'hide_empty' => true
	], $args);

	# Get all taxonomies associated with this PT
	$taxonomies = get_object_taxonomies($args['post_type'], 'objects');
	$data = [];

	# Go through them all
	foreach ($taxonomies as $tax) {
		$hasActive = false; # Whether this taxonomy has any terms active
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
				$isActive = false;

				# See if this term is active
				if (isset($_GET[$taxQueryName]) and is_array($_GET[$taxQueryName])) {
					$isActive = in_array($term->slug, $_GET[$taxQueryName]) ? true : false;
				}
				else {
					$isActive = (isset($_GET[$taxQueryName]) and $term->slug == $_GET[$taxQueryName]) ? true : false;
				}

				# Store additional data about the term
				$term = [
					'term' => $term,
					'query_name' => $taxQueryName,
					'query_value' => $term->slug,
					'active' => $isActive
				];

				# Remember if this tax had any active terms
				if ($isActive) {
					$hasActive = true;
				}

				# Store the term
				$terms[] = $term;
			}

			# Store the taxonomy
			$data[] = [
				'taxonomy' => $tax,
				'has_active' => $hasActive,
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
