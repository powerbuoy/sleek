<?php if ($services) : ?>
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
			<?php foreach ($services as $service) : if (isset($urls[$service])) : ?>
				<li>
					<a href="<?php echo $urls[$service] ?>"<?php if ($service != 'Email') : ?> target="_blank" rel="noopener"<?php endif ?>>
						<?php _e($service, 'sleek') ?>
					</a>
				</li>
			<?php endif; endforeach ?>
		</ul>

	</section>
<?php elseif (current_user_can('edit_posts')) : ?>
	<p class="error"><?php _e("You haven't selected any services.", 'sleek_admin') ?></p>
<?php endif ?>
