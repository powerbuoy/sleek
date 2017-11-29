<?php
	$next = get_adjacent_post();
	$next = $next ? $next : (get_posts(['post_type' => get_post_type(), 'numberposts' => 1])[0]);
?>

<?php if ($next) : ?>
	<nav id="next-post">

		<a href="<?php the_permalink($next) ?>">
			<small><?php _e('Next post', 'sleek') ?></small>
			<?php echo $next->post_title ?>
		</a>

	</nav>
<?php endif ?>
