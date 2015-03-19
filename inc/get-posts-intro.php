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
	#	$title		= __(sprintf('Posts categorized <strong>"%s"</strong>', single_cat_title('', false)), 'sleek');
		$title		= single_cat_title('', false);
		$content	= false; # TODO: Grab taxonomy description
	}
	elseif (is_tag()) {
		$title		= sprintf(__('Posts tagged with <strong>"%s"</strong>', 'sleek'), single_tag_title('', false));
		$content	= false; # TODO: Grab taxonomy description
	}
	elseif (is_tax()) {
		$term		= $wp_query->get_queried_object();
		$title		= $term->name;
		$content	= false; # TODO: Grab taxonomy description
	}
	elseif (is_search()) {
		if (have_posts()) {
			$title		= sprintf(__('Search results (%s) for: <strong>"%s"</strong>', 'sleek'), $wp_query->found_posts, get_search_query());
			$content	= false;
		}
		else {
			$title		= sprintf(__('No search results for: <strong>"%s"</strong>', 'sleek'), get_search_query());
			$content	= '<p>' . __("We couldn't find any matching search results for your query.", 'sleek') . '</p>';
		}
	}
	elseif (is_author()) {
		the_post();

		$title		= sprintf(__('Posts by <strong>%s</strong>', 'sleek'), get_the_author());
		$content	= false; # TODO: Grab author description

		rewind_posts();
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
		ob_start();
		post_type_archive_title();

		$title = ob_get_contents();

		ob_end_clean();

		$title = __($title, 'sleek');
	}
	else {
		$title = __('Posts', 'sleek');
	}

	return array(
		'title'		=> $title, 
		'content'	=> $content
	);
}
