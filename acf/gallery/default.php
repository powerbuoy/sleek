<section id="gallery">

	<?php if ($gallery_title or $gallery_description) : ?>
		<header>

			<?php if ($gallery_title) : ?>
				<h2><?php echo $gallery_title ?></h2>
			<?php endif ?>

			<?php echo $gallery_description ?>

		</header>
	<?php endif ?>

	<ul>
		<?php foreach ($gallery_images as $image) : ?>
			<li>
				<figure>
					<a href="<?php echo $image['url'] ?>">
						<?php echo wp_get_attachment_image($image['id'], 'medium') ?>
					</a>

					<figcaption>

						<h3><?php echo $image['title'] ?></h3>

						<?php echo wpautop($image['caption']) ?>
						<?php echo wpautop($image['description']) ?>

					</figcaption>
				</figure>
			</li>
		<?php endforeach ?>
	</ul>

</section>
