<?php
	$parentId = $child_pages_page_id ? $child_pages_page_id : $post->ID;

	$rows = get_pages([
		'parent' => $parentId,
		'sort_column' => 'menu_order',
		'sort_order' => 'ASC'
	]);
?>

<?php if ($rows) : ?>
	<section id="child-pages">

		<?php if ($child_pages_title or $child_pages_description) : ?>
			<header>

				<?php if ($child_pages_title) : ?>
					<h2><?php echo $child_pages_title ?></h2>
				<?php endif ?>

				<?php echo $child_pages_description ?>

			</header>
		<?php endif ?>

		<?php foreach ($rows as $post) : setup_postdata($post) ?>
			<?php get_template_part('modules/archive-post', get_post_type()) ?>
		<?php endforeach; wp_reset_postdata() ?>

	</section>
<?php else : ?>
	<p class="error"><?php _e('This page does not have any child pages. You can remove this module until you add some.', 'sleek') ?></p>
<?php endif ?>
