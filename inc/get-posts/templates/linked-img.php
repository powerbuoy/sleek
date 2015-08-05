<?php if ($rows) : ?>
	<?php global $post; foreach ($rows as $post) : setup_postdata($post) ?>
		<a href="<?php the_permalink() ?>"><?php the_post_thumbnail($img_size) ?></a>
	<?php endforeach; wp_reset_postdata() ?>
<?php endif ?>
