<?php
	$tmp		= sleek_get_posts_intro();
	$title		= $tmp['title'];
	$content	= $tmp['content'];
?>

<?php if ($title or $content) : ?>
	<header id="posts-intro">

		<?php if ($title) : ?>
			<h1><?php echo $title ?></h1>
		<?php endif ?>

		<?php if ($content) : ?>
			<?php echo $content ?>
		<?php endif ?>

	</header>
<?php endif ?>
