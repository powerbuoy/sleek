<?php
	$parentId = $sibling_pages_page_id ? $sibling_pages_page_id : $post->post_parent;
	$rows = false;
	$thisId = $post->ID;

	if ($parentId) {
		$rows = get_posts([
			'post_type' => 'page',
			'post_parent' => $parentId,
			'orderby' => 'menu_order',
			'sort' => 'ASC'
		]);
	}
?>

<?php if ($rows) : ?>
	<section id="child-pages">

		<?php if ($sibling_pages_title or $sibling_pages_description) : ?>
			<header>

				<?php if ($sibling_pages_title) : ?>
					<h2><?php echo $sibling_pages_title ?></h2>
				<?php endif ?>

				<?php echo $sibling_pages_description ?>

			</header>
		<?php endif ?>

		<?php foreach ($rows as $post) : setup_postdata($post) ?>
			<?php get_template_part('modules/archive-post', get_post_type()) ?>
		<?php endforeach; wp_reset_postdata() ?>

	</section>
<?php else : ?>
	<p class="error"><?php _e('This page does not have any siblings. You can remove this module until you add some.', 'sleek') ?></p>
<?php endif ?>
