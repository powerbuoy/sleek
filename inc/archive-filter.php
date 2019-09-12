<?php
/**
 * Returns list of all taxonomies associated with $args['post_type']
 * along with data used for displaying said taxonomies in a form
 */
function sleek_get_archive_filter_taxonomies ($args = []) {
	# Default args
	$args = array_merge([
		'post_type' => sleek_get_current_post_type(),
		'hide_empty' => true
	], $args);

	# Get all taxonomies associated with this PT
	$taxonomies = get_object_taxonomies($args['post_type'], 'objects');
	$data = [];

	# Go through them all
	foreach ($taxonomies as $tax) {
		$hasActive = false; # Whether this taxonomy has any terms active
		$activeTerm = false; # Store the active term
		$taxQueryName = 'sleek_filter_tax_' . $tax->name; # Name of ?get parameter

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
					$activeTerm = $term;
				}

				# Store the term
				$terms[] = $term;
			}

			# Store the taxonomy
			$data[] = [
				'taxonomy' => $tax,
				'has_active' => $hasActive,
				'query_name' => $taxQueryName,
				'terms' => $terms
			];
		}
	}

	return $data;
}

# Add support for filtering on sleek_filter_* parameters
add_filter('pre_get_posts', function ($query) {
	if (!is_admin() and $query->is_main_query()) {
		# Build potential tax and meta query
		$taxQuery = $query->get('tax_query', ['relation' => 'AND']);
		$metaQuery = $query->get('meta_query', ['relation' => 'AND']);
		$hasTaxQuery = false;
		$hasMetaQuery = false;

		# Go through all get params
		foreach ($_GET as $k => $v) {
			# If this is a sleek filter taxonomy
			if (substr($k, 0, strlen('sleek_filter_tax_')) === 'sleek_filter_tax_') {
				$tax = substr($k, strlen('sleek_filter_tax_'));
				$val = $_GET[$k];
				$val = is_array($val) ? array_filter($val) : array_filter([$val]);

				if (!empty($val)) {
					$hasTaxQuery = true;
					$taxQuery[] = [
						'taxonomy' => $tax,
						'field' => 'term_id',
						'terms' => $val
					];
				}
			}
			# Or a sleek filter meta min query
			elseif (substr($k, 0, strlen('sleek_filter_meta_min_')) === 'sleek_filter_meta_min_') {
				$meta = substr($k, strlen('sleek_filter_meta_min_'));
				$val = $_GET[$k];
				$val = is_array($val) ? array_filter($val) : array_filter([$val]);

				if (!empty($val)) {
					$hasMetaQuery = true;

					foreach ($val as $v) {
						$metaQuery[] = [
							'key' => $meta,
							'value' => $v,
							'compare' => '>=',
							'type' => is_numeric($v) ? 'NUMERIC' : 'CHAR'
						];
					}
				}
			}
			# Max query
			elseif (substr($k, 0, strlen('sleek_filter_meta_max_')) === 'sleek_filter_meta_max_') {
				$meta = substr($k, strlen('sleek_filter_meta_max_'));
				$val = $_GET[$k];
				$val = is_array($val) ? array_filter($val) : array_filter([$val]);

				if (!empty($val)) {
					$hasMetaQuery = true;

					foreach ($val as $v) {
						$metaQuery[] = [
							'key' => $meta,
							'value' => $v,
							'compare' => '<=',
							'type' => is_numeric($v) ? 'NUMERIC' : 'CHAR'
						];
					}
				}
			}
			# Equal query
			elseif (substr($k, 0, strlen('sleek_filter_meta_')) === 'sleek_filter_meta_') {
				$meta = substr($k, strlen('sleek_filter_meta_'));
				$val = $_GET[$k];
				$val = is_array($val) ? array_filter($val) : array_filter([$val]);

				if (!empty($val)) {
					$hasMetaQuery = true;

					foreach ($val as $v) {
						$metaQuery[] = [
							'key' => $meta,
							'value' => $v,
							'compare' => '=',
							'type' => is_numeric($v) ? 'NUMERIC' : 'CHAR'
						];
					}
				}
			}
		}

		if ($hasTaxQuery) {
			$query->set('tax_query', $taxQuery);
		}
		if ($hasMetaQuery) {
			$query->set('meta_query', $metaQuery);
		}

		# See if a search string is provided
		if (isset($_GET['sleek_filter_search'])) {
			$query->set('s', $_GET['sleek_filter_search']);
		}
	}
});
