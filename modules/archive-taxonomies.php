<?php $archiveData = sleek_get_archive_data() ?>

<?php # TODO: Create a real search form with ?s and all taxonomies ?>
<?php if ($archiveData and $archiveData['taxonomies']) : ?>
	<nav id="archive-taxonomies">

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
