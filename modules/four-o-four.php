<?php
	# http://alistapart.com/article/perfect404
	$referrer		= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false;
	$referrerSite	= false;
	$internalRef	= stristr($referrer, $_SERVER['SERVER_NAME']);
	$searchRef		= (
		stristr($referrer, 'looksmart.co') or
		stristr($referrer, 'ifind.freeserve.co') or
		stristr($referrer, 'ask.co') or
		stristr($referrer, 'google.') or
		stristr($referrer, 'altavista.co') or
		stristr($referrer, 'msn.co') or
		stristr($referrer, 'yahoo.co')
	);

	if ($referrer) {
		$referrerSite = explode('/', $referrer);
		$referrerSite = $referrerSite[2];
	}

	# Get some search results
	$searchTerm = str_replace(['/', '?', '-', '_'], ' ', $_SERVER['REQUEST_URI']);
	$searchResults = false;

	if (!empty($searchTerm)) {
		if (function_exists('relevanssi_do_query')) {
			$searchQuery = new WP_Query();

			$searchQuery->parse_query([
				'post_type' => 'any',
				'posts_per_page' => 3,
				's' => $searchTerm
			]);

			relevanssi_do_query($searchQuery);

			if ($searchQuery->posts and !is_wp_error($searchQuery->posts) and count($searchQuery->posts)) {
				$searchResults = $searchQuery->posts;
			}
		}
		else {
			$rows = get_posts([
				'post_type' => 'any',
				'posts_per_page' => 3,
				's' => $searchTerm,
				'suppress_filters' => false
			]);

			if ($rows and !is_wp_error($rows) and count($rows)) {
				$searchResults = $rows;
			}
		}
	}

	# Group search results by post type
	$groups = false;

	if ($searchResults) {
		$groups = [];

		foreach ($searchResults as $row) {
			if (!isset($groups[$row->post_type])) {
				$groups[$row->post_type] = [];
			}

			$groups[$row->post_type][] = $row;
		}
	}
?>

<section id="four-o-four">

	<header>

		<h1><?php _e('404 - Page not found', 'sleek') ?></h1>

		<p><?php _e('Sorry, that page could not be found.', 'sleek') ?></p>

		<?php get_search_form() ?>

	</header>

	<article>

		<?php if (!$referrer) : ?>
			<p><?php _e("It seems you arrived directly at this page, maybe it's because of:", 'sleek') ?></p>

			<ul>
				<li><?php _e('An <strong>out-of-date bookmark</strong>', 'sleek') ?></li>
				<li><?php _e('A search engine that has an <strong>out-of-date listing</strong> for us', 'sleek') ?></li>
				<li><?php _e('A <strong>miss-typed address</strong>', 'sleek') ?></li>
			</ul>
		<?php elseif ($internalRef) : ?>
			<p><?php _e('Woops! Looks like one of our internal links are out-of-date. <strong>Sincerely sorry</strong> about that! :)', 'sleek') ?></p>
		<?php elseif ($searchRef) : ?>
			<p><?php printf(__('You did a search on %s, however, their index appears to be out of date.', 'sleek'), $referrerSite) ?></p>
		<?php else : ?>
			<p><?php printf(__('You were incorrectly referred to this page by %s.', 'sleek'), $referrerSite) ?></p>
		<?php endif ?>

		<p><?php printf(__('Perhaps you can go back to the <a href="%s">home page</a> and try to navigate your way from there?', 'sleek'), home_url('/')) ?></p>

	</article>

	<?php if ($groups) : ?>
		<aside>

			<h2><?php _e('Is this what you were after?', 'sleek') ?></h2>

			<?php foreach ($groups as $postType => $rows) : ?>
				<?php $postType = get_post_type_object($postType) ?>
				<section>

					<h3><?php echo $postType->labels->name ?></h3>

					<?php foreach ($rows as $post) : setup_postdata($post) ?>
						<?php get_template_part('modules/post', get_post_type()) ?>
					<?php endforeach; wp_reset_postdata() ?>

				</section>
			<?php endforeach ?>

		</aside>
	<?php endif ?>

</section>
