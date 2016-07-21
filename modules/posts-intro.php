<?php
	$tmp = sleek_get_posts_intro();
	$title = $tmp['title'];
	$content = $tmp['content'];
	$image = false;
	$postType = get_post_type();

	if (get_option($postType . '_title')) {
		$title = get_option($postType . '_title');
		$content = false;
	}
	if (get_option($postType . '_description')) {
		$content = get_option($postType . '_description');
	}
	if (get_option($postType . '_image')) {
		$image = get_option($postType . '_image');
	}
?>

<?php if ($title or $content) : ?>
	<header id="posts-intro">

		<?php if ($title) : ?>
			<h1><?php echo $title ?></h1>
		<?php endif ?>

		<?php if ($content) : ?>
			<?php echo $content ?>
		<?php endif ?>

		<?php get_template_part('modules/posts-taxonomy-filter') ?>

	</header>
<?php endif ?>
