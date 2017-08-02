<?php
	$next = get_next_post();
	$next = $next ? $next : get_previous_post();
?>

<?php if ($next) : ?>
	<nav id="next-post">

		<a href="<?php echo get_permalink($next->ID) ?>">
			<small><?php _e('Next post', 'sleek') ?></small>
			<?php echo $next->post_title ?>
		</a>

	</nav>
<?php endif ?>
