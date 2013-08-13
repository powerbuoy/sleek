<?php
	$rows = get_posts(array(
		'category_name'	=> 'Featured', 
		'numberposts'	=> 3 # TODO: should be theme setting
	));
?>

<?php if ($rows) : ?>
	<section id="featured">

		<ul>
			<?php foreach ($rows as $post) : setup_postdata($post) ?>
				<li>
					<figure>
						<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('h5b-100') ?></a>

						<figcaption>
							<h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>

							<?php the_excerpt() ?>
						</figcaption>
					</figure>
				</li>
			<?php endforeach; wp_reset_postdata() # OMFG ?>
		</ul>

	</section>
<?php endif ?>
