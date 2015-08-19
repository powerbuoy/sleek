<?php if ($rows) : ?>
	<?php global $post; foreach ($rows as $post) : setup_postdata($post) ?>
		<a href="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id(), 'full')[0] ?>"><?php the_post_thumbnail($img_size) ?></a>
	<?php endforeach; wp_reset_postdata() ?>
<?php endif ?>
