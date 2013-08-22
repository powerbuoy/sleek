<?php
	$slugToTax	= array(
		'tags'			=> 'post_tag', 
		'categories'	=> 'category'
	);
	$taxSlug	= sanitize_title(get_the_title());
	$terms		= get_terms($slugToTax[$taxSlug], array(
		
	));
?>

<?php if ($terms and count($terms)) : ?>
	<section id="taxonomy-terms">

		<ul>
			<?php foreach ($terms as $term) : ?>
				<li><a href="<?php echo get_term_link($term) ?>"><?php echo $term->name ?> <strong><?php echo $term->count ?></strong></a></li>
			<?php endforeach ?>
		</ul>

	</section>
<?php endif ?>
