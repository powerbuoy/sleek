<?php if (($links = sleek_get_yoast_social_links()) and count($links)) : ?>
	<nav id="social-menu">

		<ul>
			<?php foreach ($links as $link) : ?>
				<li><a href="<?php echo $link['url'] ?>" target="_blank" rel="noopener"><?php echo $link['name'] ?></a></li>
			<?php endforeach ?>
		</ul>

	</nav>
<?php endif ?>
