<?php while (have_posts()) : the_post() ?>
	<section id="single-<?php echo get_post_type() ?>">

		<header>

			<h1><?php the_title() ?></h1>

			<?php the_excerpt() ?>

		</header>

		<?php
			$image = wp_get_attachment_image(get_the_ID(), 'medium', false);
			$icon = wp_get_attachment_image(get_the_ID(), 'medium', true);
		?>
		<figure class="<?php if ($image) : ?>image<?php else : ?>icon<?php endif ?>">

			<?php if ($image) : ?>
				<?php echo $image ?>
			<?php else : ?>
				<?php echo $icon ?>
			<?php endif ?>

			<figcaption>

				<dl>
					<dt><?php _e('Filename', 'sleek') ?></dt>
					<dd><?php echo basename(get_attached_file($post->ID)) ?></dd>

					<dt><?php _e('Filesize', 'sleek') ?></dt>
					<dd><?php echo size_format(filesize(get_attached_file($post->ID))) ?></dd>
				</dl>

			</figcaption>

		</figure>

		<p><a href="<?php echo get_attached_file($post->ID) ?>"><?php _e('Download', 'sleek') ?></a></p>

	</section>
<?php endwhile ?>
