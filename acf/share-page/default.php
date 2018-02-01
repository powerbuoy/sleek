<?php
	global $post;

	$urls = [
		'Facebook' => 'https://www.facebook.com/sharer.php?u={url}',
		'Twitter' => 'https://twitter.com/intent/tweet?url={url}&text={title}',
		'LinkedIn' => 'https://www.linkedin.com/shareArticle?url={url}&title={title}',
		'Google Plus' => 'https://plus.google.com/share?url={url}',
		'Email' => 'mailto:?subject={title}&body={url}'
	];

	$url = $data['share-page-url'] ? $data['share-page-url'] : sleek_curr_page_url(false);
	$title = wp_title('|', false, 'right');

	foreach ($urls as $service => $u) {
		if ($service == 'Email') {
			$urls[$service] = str_replace(['{url}', '{title}'], [$url, $title], $u);
		}
		else {
			$urls[$service] = str_replace(['{url}', '{title}'], [urlencode($url), urlencode($title)], $u);
		}
	}
?>

<section id="share-page">

	<?php if ($data['share-page-title'] or $data['share-page-description']) : ?>
		<header>

			<?php if ($data['share-page-title']) : ?>
				<h2><?php echo $data['share-page-title'] ?></h2>
			<?php endif ?>

			<?php echo $data['share-page-description'] ?>

		</header>
	<?php endif ?>

	<ul>
		<?php foreach ($data['share-page-services'] as $service) : ?>
			<li>
				<a href="<?php echo $urls[$service] ?>" <?php if ($service != 'Email') : ?>target="_blank"<?php endif ?>>
					<?php echo __($service, 'sleek') ?>
				</a>
			</li>
		<?php endforeach ?>
	</ul>

</section>
