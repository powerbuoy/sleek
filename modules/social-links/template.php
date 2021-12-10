<?php if ($links) : ?>
	<nav id="social-links">

		<?php if ($title or $description) : ?>
			<header>

				<?php if ($title) : ?>
					<h2><?php echo $title ?></h2>
				<?php endif ?>

				<?php echo $description ?>

			</header>
		<?php endif ?>

		<ul>
			<?php foreach ($links as $link) : ?>
				<li>
					<a href="<?php echo $link->url ?>" target="_blank" rel="noopener">
						<?php echo $link->name ?>
					</a>
				</li>
			<?php endforeach ?>
		</ul>

	</nav>
<?php elseif (current_user_can('edit_posts')) : ?>
	<p class="error"><?php _e("You haven't added any Social Media URLs to Yoast SEO.", 'sleek_admin') ?></p>
<?php endif ?>
