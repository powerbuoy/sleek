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

/*	if ($searchRef) {
		$qryStrings = array(
			'q', 
			'p', 
			'ask', 
			'key'
		);

		$params = explode('?', $referrer);
		$params = explode('&', $params[1]);

		foreach ($params as $p) {
			$ps = explode('=', $p);

			if (in_array($ps[0], $qryStrings)) {
				$q = str_replace('+', ' ', $ps[1]);
			}
		}
	} */

	$q = "?";
?>

<section id="four-o-four">

	<header>

		<h1><?php _e('404 - Page not found', 'sleek') ?></h1>

		<p><?php _e('Sorry, that page could not be found.', 'sleek') ?></p>

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
			<p><?php _e('Woops! Looks like one of our internal links are out-of-date. <strong>Sincerly sorry</strong> about that! :)', 'sleek') ?></p>
		<?php elseif ($searchRef) : ?>
			<p><?php printf(__('You did a search on %s, however, their index appears to be out of date.', 'sleek'), $referrerSite, $q) ?></p>
		<?php else : ?>
			<p><?php printf(__('You were incorrectly referred to this page by <a href="%s">%s</a>.', 'sleek'), str_replace('&', '&amp;', $referrer), $referrerSite) ?></p>
		<?php endif ?>

		<p><?php printf(__('Perhaps you can go back to the <a href="%s">home page</a> and try to navigate your way from there?', 'sleek'), home_url('/')) ?></p>

	</article>

	<aside>

		<p><?php _e('...or try a search?', 'sleek') ?></p>

		<?php sleek_get_module('search') ?>

	</aside>

</section>
