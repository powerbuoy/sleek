<?php
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
	#	$title		= __(sprintf('News categorized <strong>"%s"</strong>', single_cat_title('', false)), 'h5b');
		$title		= single_cat_title('', false);
		$content	= false; # TODO: Grab taxonomy description
	}
	elseif (is_tag()) {
		$title		= __(sprintf('News tagged with <strong>"%s"</strong>', single_tag_title('', false)), 'h5b');
		$content	= false; # TODO: Grab taxonomy description
	}
	elseif (is_search()) {
		if (have_posts()) {
			$title		= __(sprintf('Search results (%s) for: <strong>"%s"</strong>', $wp_query->found_posts, get_search_query()), 'h5b');
			$content	= false;
		}
		else {
			$title		= __(sprintf('No search results for: <strong>"%s"</strong>', get_search_query()), 'h5b');
			$content	= '<div class="left"><p>' . __("We couldn't find any matching search results for your query.", 'h5b') . '</p>';

			$content	.= fetch(TEMPLATEPATH . '/modules/navigation-tips.php') . '</div><div class="right">';
			$content	.= fetch(TEMPLATEPATH . '/modules/quick-search.php') . '</div>';
		}
	}
	elseif (is_author()) {
		the_post();

		$title		= __(sprintf('Posts by <strong>%s</strong>', get_the_author()), 'h5b');
		$content	= false; # TODO: Grab author description

		rewind_posts();
	}
	elseif (is_day()) {
		$title = __(sprintf('Daily archives <strong>%s</strong>', get_the_time('l, F j, Y')), 'h5b');
	}
	elseif (is_month()) {
		$title = __(sprintf('Monthly archives <strong>%s</strong>', get_the_time('F Y')), 'h5b');
	}
	elseif (is_year()) {
		$title = __(sprintf('Yearly archives <strong>%s</strong>', get_the_time('Y')), 'h5b');
	}
	elseif (is_post_type_archive()) {
		ob_start();
		post_type_archive_title();

		$title = ob_get_contents();

		ob_end_clean();

		$title = __($title, 'h5b');
	}
	else {
		$title = __('News', 'h5b');
	}
?>

<?php if ($title or $content) : ?>
	<section id="posts-intro">

		<?php if ($title) : ?>
			<h1><?php echo $title ?></h1>
		<?php endif ?>

		<?php if ($content) : ?>
			<?php echo $content ?>
		<?php endif ?>

	</section>
<?php endif ?>
