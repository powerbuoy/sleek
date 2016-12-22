<?php
/**
 * Returns valuable data such as title/description
 * based on the currently viewed type of archive
 * (cpt, blog, category, date, search etc)
 */
function sleek_get_archive_data ($args = []) {
	global $post;
	global $wp_query;

	# Args
	$args = array_merge([
		'image_size' => 'full',
		'date_formats' => [
			'yearly' => 'Y',
			'monthly' => 'F Y',
			'daily' => 'l, F j, Y'
		],
		'hide_empty_terms' => true
	], $args);

	# Return data
	$data = [
		'title' => false,
		'post_type_title' => false,
		'content' => false,
		'image' => false,
		'image_id' => false,
		'taxonomies' => false,
		'post_type' => false
	];

	# The normal blog archive
	if (is_home()) {
		$data['post_type'] = 'post';
		$data['post_type_title'] = get_the_title(get_option('page_for_posts'));
		$data['title'] = get_the_title(get_option('page_for_posts'));
		$data['content'] = apply_filters('the_content', get_post_field('post_content', get_option('page_for_posts')));
		$data['image'] = has_post_thumbnail(get_option('page_for_posts')) ? get_the_post_thumbnail_url(get_option('page_for_posts'), $args['image_size']) : false;
		$data['image_id'] = get_post_thumbnail_id(get_option('page_for_posts'));
		$data['taxonomies'] = sleek_get_taxonomies_by_post_type('post', ['hide_empty' => $args['hide_empty_terms']]);
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
		$data['taxonomies'] = sleek_get_taxonomies_by_post_type('post', ['hide_empty' => $args['hide_empty_terms']]);
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
		$data['taxonomies'] = sleek_get_taxonomies_by_post_type('post', ['hide_empty' => $args['hide_empty_terms']]);
	}

	# Date blog archives
	elseif (is_year() or is_month() or is_day()) {
		$data['post_type'] = 'post';
		$data['post_type_title'] = get_the_title(get_option('page_for_posts'));
		$data['image'] = has_post_thumbnail(get_option('page_for_posts')) ? get_the_post_thumbnail_url(get_option('page_for_posts'), $args['image_size']) : false;
		$data['image_id'] = get_post_thumbnail_id(get_option('page_for_posts'));
		$data['taxonomies'] = sleek_get_taxonomies_by_post_type('post', ['hide_empty' => $args['hide_empty_terms']]);

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

				if ($imageId = get_option($data['post_type'] . '_image')) {
					$data['image'] = wp_get_attachment_image_src($imageId, $args['image_size'])[0];
					$data['image_id'] = $imageId;
				}
				if ($title = get_option($data['post_type'] . '_title')) {
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
		$data['taxonomies'] = sleek_get_taxonomies_by_post_type($data['post_type'], ['hide_empty' => $args['hide_empty_terms']]);

		if ($imageId = get_option($data['post_type'] . '_image')) {
			$data['image'] = wp_get_attachment_image_src($imageId, $args['image_size'])[0];
			$data['image_id'] = $imageId;
		}
		if ($title = get_option($data['post_type'] . '_title')) {
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
		$data['taxonomies'] = sleek_get_taxonomies_by_post_type($data['post_type'], ['hide_empty' => $args['hide_empty_terms']]);

		if ($title = get_option($data['post_type'] . '_title')) {
			$data['post_type_title'] = $data['title'] = $title;
		}
		if ($description = get_option($data['post_type'] . '_description')) {
			$data['content'] = wpautop($description);
		}
		if ($imageId = get_option($data['post_type'] . '_image')) {
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

function sleek_get_taxonomies_by_post_type ($pt = 'post', $args = []) {
	# Args
	$args = array_merge([
		'hide_empty' => true
	], $args);

	# We need these to convert some query params
	$taxConverter	= [
		'category' => [
			'rewrite' => 'cat',
			'property' => 'term_id'
		]
	];

	# Get all taxonomies connected to this post type
	$taxs = get_object_taxonomies($pt, 'names');
	$return = [];

	# Go through them all
	foreach ($taxs as $tax) {
		# Get all the terms
		$tmp = get_terms(['taxonomy' => $tax, 'hide_empty' => $args['hide_empty']]);
		$terms = [];
		$taxQueryName = $tax;
		$property = 'slug';
		$hasSelected = false; # Whether one of the taxonomies terms is the one currently viewed

		# If this taxonomy needs to be converted (post_tag => tag, category => cat etc)
		if (isset($taxConverter[$tax])) {
			if (isset($taxConverter[$tax]['property'])) {
				$property = $taxConverter[$tax]['property'];
			}

			$taxQueryName = $taxConverter[$tax]['rewrite'];
		}

		# Only continue if this taxonomy actually has terms
		if ($tmp) {
			foreach ($tmp as $term) {
				# See if this term is selected
				if (isset($_GET[$taxQueryName]) and is_array($_GET[$taxQueryName])) {
					$filterLinkSelected = in_array($term->{$property}, $_GET[$taxQueryName]) ? true : false;
				}
				else {
					$filterLinkSelected = (isset($_GET[$taxQueryName]) and $term->{$property} == $_GET[$taxQueryName]) ? true : false;
				}

				# Store some additional data about each term
				$term = [
					'taxonomy' => $tax,
					'post_type_archive_link' => get_post_type_archive_link($pt),
					'permalink' => get_term_link($term),
					'filter_link' => get_post_type_archive_link($pt) . '?' . $taxQueryName . '=' . $term->{$property},
					'property_value' => $term->{$property},
					'filter_link_selected' => $filterLinkSelected,
					'permalink_selected' => $term->{$property} == get_query_var($taxQueryName),
					'term' => $term
				];

				if ($term['filter_link_selected'] or $term['permalink_selected']) {
					$hasSelected = true;
				}

				$terms[] = $term;
			}

			# Store some additional data about the taxonomy
			$return[] = [
				'taxonomy' => $tax,
				'query_name' => $taxQueryName,
				'property' => $property,
				'has_selected' => $hasSelected,
				'terms' => $terms
			];
		}
	}

	return $return;
}

# Add support for filtering on post_tag (everything else works out of the box in WP...)
add_filter('pre_get_posts', function ($query) {
	if (!is_admin() and $query->is_main_query()) {
		if (is_home()) { # is_post_type_archive('post') doesn't work
			if (isset($_GET['post_tag'])) {
				$taxQuery = $query->get('tax_query');
				$taxQuery[] = [
					'taxonomy' => 'post_tag',
					'field' => 'slug',
					'terms' => $_GET['post_tag'],
					'operator' => 'IN'
				];
				$query->set('tax_query', $taxQuery);
			}
		}
	}
});
