<?php
	# Get a title and description based on the type of archive
	$tmp = sleek_get_posts_intro();
	$title = $tmp['title'];
	$content = $tmp['content'];
	$image = false;

	# If we're not on one of these built in archives
	if (!(is_search() or is_author() or is_tag() or is_category() or is_date())) {
		# Look for cpt_option fields
		$postType = get_post_type();

		if (get_option($postType . '_title')) {
			$title = get_option($postType . '_title');
			$content = false; # If a cpt title is set, remove the auto-generated description
		}
		if (get_option($postType . '_description')) {
			$content = get_option($postType . '_description');
		}
		if (get_option($postType . '_image')) {
			$image = get_option($postType . '_image');
			$imageSrc = wp_get_attachment_image_src($image, 'sleek-hd');
		}

		# For the blog archive
		if (!$image and has_post_thumbnail()) {
			$image = true;
			$imageSrc = [get_the_post_thumbnail_url($post->ID, 'sleek-hd')];
		}
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
