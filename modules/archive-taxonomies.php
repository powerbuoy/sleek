<?php
	if ($taxonomies = get_object_taxonomies(sleek_get_current_post_type(), 'objects')) {
		$taxonomies = array_filter($taxonomies, function ($tax) {
			return $tax->public;
		});
	}
?>

<?php if ($taxonomies) : ?>
	<section id="archive-taxonomies">

		<h2><?php _e('Filter posts', 'sleek') ?></h2>

		<?php foreach ($taxonomies as $tax) : ?>
			<?php
				$output = wp_list_categories([
					'taxonomy' => $tax->name,
					'title_li' => false,
					'show_option_all' => __('All', 'sleek'),
					'echo' => false
				]);
			?>
			<?php if ($output) : ?>
				<nav>

					<h3><?php echo $tax->labels->name ?></h3>

					<ul>
						<?php echo $output ?>
					</ul>

				</nav>
			<?php endif ?>
		<?php endforeach ?>

	</section>
<?php endif ?>
