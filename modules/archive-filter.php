<?php
	# NOTE: You can change from radio buttons to checkboxes by changing:
	# - radio => checkbox
	# - add [] to the end of the name (it needs to be an array if we're going to select multiple)
	# - remove the "all" option (it doesn't make sense with checkboxes)
?>

<section id="archive-filter">

	<h2><?php _e('Filter posts', 'sleek') ?></h2>

	<form method="get" action="<?php echo get_post_type_archive_link(sleek_get_current_post_type()) ?>">

		<p>
			<label>
				<?php _e('Search', 'sleek') ?><br>
				<input type="search" name="sleek_filter_search" value="<?php echo isset($_GET['sleek_filter_search']) ? htmlspecialchars($_GET['sleek_filter_search']) : '' ?>">
			</label>
		</p>

		<?php if ($taxonomies = sleek_get_archive_filter_taxonomies()) : foreach ($taxonomies as $tax) : ?>
			<fieldset>

				<legend><?php echo $tax['taxonomy']->labels->name ?></legend>

				<ul>
					<li>
						<label>
							<input type="radio" name="<?php echo $tax['query_name'] ?>" value="" <?php echo $tax['has_active'] ? '' : 'checked' ?>>
							<?php _e('All', 'sleek') ?>
						</label>
					</li>
					<?php foreach ($tax['terms'] as $term) : ?>
						<li>
							<label>
								<input type="radio" name="<?php echo $term['query_name'] ?>" value="<?php echo $term['query_value'] ?>" <?php echo $term['active'] ? 'checked' : '' ?>>
								<?php echo $term['term']->name ?>
							</label>
						</li>
					<?php endforeach ?>
				</ul>

			</fieldset>
		<?php endforeach; endif ?>

		<p><button><?php _e('Filter', 'sleek') ?></button></p>

	</form>

</section>
