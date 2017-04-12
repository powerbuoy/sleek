<?php $archiveData = sleek_get_archive_data([
	'image_size' => 'sleek-hd'
]) ?>

<?php if ($archiveData) : ?>
	<section id="archive-header">

		<header>

			<?php if ($archiveData['image']) : ?>
				<img src="<?php echo $archiveData['image'] ?>">
			<?php endif ?>

			<?php if ($archiveData['title']) : ?>
				<h1><?php echo $archiveData['title'] ?></h1>
			<?php endif ?>

			<?php echo $archiveData['content'] ?>

		</header>

		<?php if ($archiveData['taxonomies']) : ?>
			<nav>

				<?php foreach ($archiveData['taxonomies'] as $tax) : ?>
					<ul>
						<li<?php if (!$tax['has_selected']) : ?> class="selected"<?php endif ?>>
							<a href="<?php echo get_post_type_archive_link($archiveData['post_type']) ?>"><?php _e('All', 'sleek') ?></a>
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
