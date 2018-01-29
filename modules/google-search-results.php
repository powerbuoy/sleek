<?php
	$results = false;

	$query = (isset($_GET['s']) and !empty($_GET['s'])) ? $_GET['s'] : false;
	$title = __('Empty search', 'sleek');

	$limit = get_option('posts_per_page');
	$start = (isset($_GET['google_search_start']) and is_numeric($_GET['google_search_start'])) ? $_GET['google_search_start'] : 1;

	$apiKey = get_theme_mod('google_search_api_key');
	$cx = get_theme_mod('google_search_engine_id');

	if ($query) {
		$endpoint = 'https://www.googleapis.com/customsearch/v1';
		$endpoint .= '?key=' . $apiKey;
		$endpoint .= '&cx=' . $cx;
		$endpoint .= '&q=' . urlencode($query);
		$endpoint .= '&num=' . $limit;
		$endpoint .= '&start=' . $start;

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, get_site_url());

		$results = curl_exec($ch);

		curl_close($ch);

		if ($results) {
			$results = json_decode($results);
			$numResults = (isset($results->queries) and isset($results->queries->request) and count($results->queries->request) and isset($results->queries->request[0]->totalResults)) ? $results->queries->request[0]->totalResults : '?';
			$title = sprintf(__("Search results (%s) for: <strong>\"%s\"</strong>", 'sleek'), $numResults, $query);
		}
	}
?>

<header id="archive-header">

	<h1><?php echo $title ?></h1>

	<?php if ($numResults and isset($results->queries) and isset($results->queries->request) and count($results->queries->request)) : ?>
		<p><?php printf(__('Displaying results %d through %d', 'sleek'), $results->queries->request[0]->startIndex, $results->queries->request[0]->count) ?></p>
	<?php elseif (!$numResults) : ?>
		<p><?php printf(__('No search results for: <strong>"%s"</strong>', 'sleek'), $query) ?></p>
	<?php endif ?>

	<?php get_template_part('modules/search') ?>

	<?php if (isset($results->spelling)) : ?>
		<p><?php printf(__('Showing search results for %s', 'sleek'), $results->spelling->htmlCorrectedQuery) ?></p>
	<?php endif ?>

</header>

<section id="google-search-results">

	<?php if ($results and isset($results->items)) : ?>
		<?php foreach ($results->items as $item) : ?>
			<article>

				<?php if (isset($item->pagemap->cse_image) and count($item->pagemap->cse_image)) : ?>
					<figure>
						<a href="<?php echo $item->link ?>">
							<img src="<?php echo $item->pagemap->cse_image[0]->src ?>">
						</a>
					</figure>
				<?php endif ?>

				<h2>
					<a href="<?php echo $item->link ?>">
						<?php echo $item->htmlTitle ?>
					</a>
				</h2>

				<p><?php echo $item->htmlSnippet ?></p>

				<a href="<?php echo $item->link ?>"><?php _e('Read more', 'sleek') ?></a>

			</article>
		<?php endforeach ?>
	<?php else : ?>
		<p><strong><?php _e('Sorry, nothing was found here.', 'sleek') ?></strong></p>
	<?php endif ?>

</section>

<?php if ($results and isset($results->queries)) : ?>
	<nav id="pagination">

		<?php if (isset($results->queries->previousPage)) : ?>
			<a href="<?php echo home_url() ?>?s=<?php echo $query ?>&amp;google_search_start=<?php echo $results->queries->previousPage[0]->startIndex ?>" class="prev">
				<?php _e('Previous page', 'sleek') ?>
			</a>
		<?php endif ?>

		<?php if (isset($results->queries->nextPage)) : ?>
			<a href="<?php echo home_url() ?>?s=<?php echo $query ?>&amp;google_search_start=<?php echo $results->queries->nextPage[0]->startIndex ?>" class="next">
				<?php _e('Next page', 'sleek') ?>
			</a>
		<?php endif ?>

	</nav>
<?php endif ?>
