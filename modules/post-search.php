<article class="post--search">

	<a href="<?php the_permalink() ?>">

		<h2><?php the_title() ?></h2>

		<cite><?php the_permalink() ?></cite>

		<strong><?php echo get_post_type_object(get_post_type())->labels->singular_name ?></strong>

		<?php the_excerpt() ?>

	</a>

</article>
