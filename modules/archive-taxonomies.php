<?php if ($taxonomies = sleek_get_post_type_taxonomies()) : ?>
	<section id="archive-taxonomies">

		<?php foreach ($taxonomies as $tax) : ?>
			<nav>

				<h2><?php echo $tax['taxonomy']->labels->name ?></h2>

				<ul>
					<li<?php if (!$tax['has_selected']) : ?> class="selected"<?php endif ?>>
						<a href="<?php echo $tax['post_type_archive_link'] ?>"><?php _e('All', 'sleek') ?></a>
					</li>
					<?php foreach ($tax['terms'] as $term) : ?>
						<li<?php if ($term['selected']) : ?> class="selected"<?php endif ?>>
							<a href="<?php echo $term['permalink'] ?>">
								<?php echo $term['term']->name ?>
							</a>
						</li>
					<?php endforeach ?>
				</ul>

			</nav>
		<?php endforeach ?>

	</section>
<?php endif ?>
