<?php
	$taxSlug = sanitize_title(get_the_title());
	$terms = get_terms($taxSlug, array(
		
	));
?>

<?php if ($terms and count($terms)) : ?>
	<section id="taxonomy-terms">

		<ul>
			<?php foreach ($terms as $term) : ?>
				<li>
					<?php $tIMG = z_taxonomy_image_url($term->term_id) ?>
					<?php if ($tIMG) : ?>
						<img src="<?php echo $tIMG ?>">
					<?php endif ?>

					<h3><a href="<?php echo get_term_link($term) ?>"><?php echo $term->name ?></a></h3>

					<?php if ($term->description) : ?>
						<p><?php echo $term->description ?></p>
					<?php endif ?>
				</li>
			<?php endforeach ?>
		</ul>

	</section>
<?php endif ?>
