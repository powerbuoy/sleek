<section id="archive-filter">

	<form method="get" action="">

		<p>
			<label for="archive-filter-search"><?php _e('Search', 'sleek') ?></label>
			<input type="search" name="sleek_filter_search" value="<?php echo isset($_GET['sleek_filter_search']) ? $_GET['sleek_filter_search'] : '' ?>">
		</p>

		<?php if ($taxonomies = sleek_get_post_type_taxonomy_filter()) : foreach ($taxonomies as $tax) : ?>
			<ul>
				<li>
					<label>
						<input type="radio" name="<?php echo $tax['query_name'] ?>" value="" <?php echo $tax['has_selected'] ? '' : 'checked' ?>>
						<?php _e('All', 'sleek') ?>
					</label>
				</li>
				<?php foreach ($tax['terms'] as $term) : ?>
					<li>
						<label>
							<input type="radio" name="<?php echo $term['query_name'] ?>" value="<?php echo $term['query_value'] ?>" <?php echo $term['selected'] ? 'checked' : '' ?>>
							<?php echo $term['term']->name ?>
						</label>
					</li>
				<?php endforeach ?>
			</ul>
		<?php endforeach; endif ?>

		<p>
			<button type="submit"><?php _e('Filter', 'sleek') ?></button>
		</p>

	</form>

</section>
