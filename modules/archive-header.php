<?php $introData = sleek_get_archive_data([
	'image_size' => 'sleek-hd'
]) ?>

<?php if ($introData) : ?>
	<section id="archive-header">

		<header>

			<?php if ($introData['image']) : ?>
				<img src="<?php echo $introData['image'] ?>">
			<?php endif ?>

			<?php if ($introData['title']) : ?>
				<h1><?php echo $introData['title'] ?></h1>
			<?php endif ?>

			<?php echo $introData['content'] ?>

		</header>

		<?php if ($introData['taxonomies']) : ?>
			<nav>

				<?php foreach ($introData['taxonomies'] as $tax) : ?>
					<ul>
						<li<?php if (!$tax['has_selected']) : ?> class="selected"<?php endif ?>>
							<a href="<?php echo get_post_type_archive_link($introData['post_type']) ?>"><?php _e('All', 'sleek') ?></a>
						</li>
						<?php foreach ($tax['terms'] as $term) : ?>
							<li<?php if ($term['permalink_selected']) : ?> class="selected"<?php endif ?>>
								<a href="<?php echo $term['permalink'] ?>">
									<?php echo $term['term']->name ?>
								</a>
							</li>
						<?php endforeach ?>
					</ul>
				<?php endforeach ?>

			</nav>
		<?php endif ?>

	</section>
<?php endif ?>
