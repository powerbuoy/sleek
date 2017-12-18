<?php if ($taxonomies = get_object_taxonomies(sleek_get_current_post_type(), 'objects')) : ?>
	<section id="archive-taxonomies">

		<?php foreach ($taxonomies as $tax) : ?>
			<?php
				# Get all categories
				$output = wp_list_categories([
					'taxonomy' => $tax->name,
					'title_li' => false,
					'show_option_all' => __('All', 'sleek'),
					'echo' => false
				]);

				# If there's no current cat - add the class to the "all" link
				if (strpos($output, 'current-cat') === false) {
					$output = str_replace('cat-item-all', 'cat-item-all current-cat', $output);
				}

				# If there are no categories, don't display anything
				if (strpos($output, 'cat-item-none') !== false) {
					$output = false;
				}
			?>
			<?php if ($output) : ?>
				<nav>

					<h2><?php echo $tax->labels->name ?></h2>

					<ul>
						<?php echo $output ?>
					</ul>

				</nav>
			<?php endif ?>
		<?php endforeach ?>

	</section>
<?php endif ?>
