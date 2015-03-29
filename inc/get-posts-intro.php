<?php
/**
 * Returns a $title and $content about the current posts being shown
 * For example, "Posts tagget width "foo"" - to be used in post-listings
 */
function sleek_get_posts_intro () {
	global $post;
	global $wp_query;

	$title		= false;
	$content	= false;

	# If we're using a static front page and are on the posts home page
	if (get_option('show_on_front') == 'page' and get_option('page_for_posts') and is_home()) {
		$postsIndexID	= get_option('page_for_posts');
		$post			= get_page($postsIndexID);

		setup_postdata($post);

		$title = get_the_title();

		# Godda love WP... get_the_content() doesn't return the same thing as the_content()
		ob_start();
		the_content();

		$content = ob_get_contents();

		ob_end_clean();
		wp_reset_postdata();
	}
	# Else; if we're on another listing page such as by year or category or a custom post type
	elseif (is_category()) {
	#	$title		= __(sprintf('Posts categorized <strong>“%s”</strong>', single_cat_title('', false)), 'sleek');
		$title		= single_cat_title('', false);
		$content	= false; # TODO: Grab taxonomy description
	}
	elseif (is_tag()) {
		$title		= sprintf(__('Posts tagged with <strong>“%s”</strong>', 'sleek'), single_tag_title('', false));
		$content	= false; # TODO: Grab taxonomy description
	}
	elseif (is_tax()) {
		$term		= $wp_query->get_queried_object();
		$title		= $term->name;
		$content	= false; # TODO: Grab taxonomy description
	}
	elseif (is_search()) {
		if (have_posts()) {
			if (strlen(trim(get_search_query())) > 0) {
				$title		= sprintf(__('Search results (%s) for: <strong>“%s”</strong>', 'sleek'), $wp_query->found_posts, get_search_query());

				$total		= $wp_query->found_posts;
				$currPage	= $wp_query->query_vars['paged'] ? $wp_query->query_vars['paged'] : 1;
				$numPerPage	= $wp_query->query_vars['posts_per_page'];
				$resFrom	= ($currPage * $numPerPage - $numPerPage) + 1;
				$resTo		= ($resFrom + $numPerPage) - 1;
				$resTo		= $resTo > $total ? $total : $resTo;

				$content	= '<p>' . sprintf(__('Displaying results %d through %d'), $resFrom, $resTo) . '</p>';
			}
			else {
				$title		= sprintf(__('Empty search', 'sleek'), $wp_query->found_posts, get_search_query());
				$content	= '<p>' . __("You didn't search for anything in particular so I'm showing you everything") . '</p>';
			}
		}
		else {
			$title		= sprintf(__('No search results for: <strong>“%s”</strong>', 'sleek'), get_search_query());
			$content	= '<p>' . __("We couldn't find any matching search results for your query.", 'sleek') . '</p>';
		}

	#	$content = '<pre>' . var_export($wp_query, true) . '</pre>';
	}
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

		$prefix		= $usr->user_url ? '<a href="' . $usr->user_url . '">' : '';
		$suffix		= $usr->user_url ? '</a>' : '';

		$firstP		= explode("\n", get_user_meta($usr->ID, 'description', true));
		$firstP		= count($firstP) ? $firstP[0] : $firstP;

		$title		= $prefix . get_avatar($usr->ID, 320) . sprintf(__('Posts by <strong>%s</strong>', 'sleek'), $usr->display_name) . $suffix;
		$content	= '<p>' . $firstP . '</p>';
	}
	elseif (is_day()) {
		$title = sprintf(__('Daily archives <strong>%s</strong>', 'sleek'), get_the_time('l, F j, Y'));
	}
	elseif (is_month()) {
		$title = sprintf(__('Monthly archives <strong>%s</strong>', 'sleek'), get_the_time('F Y'));
	}
	elseif (is_year()) {
		$title = sprintf(__('Yearly archives <strong>%s</strong>', 'sleek'), get_the_time('Y'));
	}
	elseif (is_post_type_archive()) {
		$postType = get_post_type_object($wp_query->query['post_type']);

		$title = $postType->labels->name;
		$content = '<p>' . nl2br($postType->description) . '</p>';
	}
	else {
		$title = __('Posts', 'sleek');
	}

	return array(
		'title'		=> $title, 
		'content'	=> $content
	);
}
