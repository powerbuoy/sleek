<section id="share-page">

	<?php if ($title or $description) : ?>
		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>
	<?php endif ?>

	<ul>
		<?php foreach ($services as $service) : ?>
			<li>
				<a href="<?php echo $urls[$service] ?>"<?php if ($service != 'Email') : ?> target="_blank" rel="noopener"<?php endif ?>>
					<?php _e($service, 'sleek') ?>
				</a>
			</li>
		<?php endforeach ?>
	</ul>

</section>
