<?php
	global $post;

	$tmp		= sleek_get_posts_intro();
	$title		= $tmp['title'];
	$content	= $tmp['content'];
?>

<?php if ($title) : ?>
	<h2><?php echo $title ?></h2>
<?php endif ?>

<?php if (have_posts()) : ?>
	<ul>
		<?php while (have_posts()) : the_post() ?>
			<li>
				<a href="<?php the_permalink() ?>">
					<?php the_post_thumbnail() ?> 
					<?php the_title() ?>
				</a>
			</li>
		<?php endwhile ?>
	</ul>
<?php endif ?>
