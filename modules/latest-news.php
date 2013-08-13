<?php
	$rows = get_posts(array(
		'category_name'	=> 'News', 
		'numberposts'	=> 3
	));
?>

<?php if ($rows) : ?>
	<section id="latest-news">

		<h2><?php _e('Latest news', 'h5b') ?></h2>

		<ul>
			<?php foreach ($rows as $post) : setup_postdata($post) ?>
				<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
			<?php endforeach; wp_reset_postdata() # OMFG ?>
		</ul>

	</section>
<?php endif ?>
