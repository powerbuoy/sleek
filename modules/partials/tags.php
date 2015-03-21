<?php
	$tag2ico = array(
		'design' => 'apple', 
		'responsive' => 'crop', 
		'rwd' => 'crop', 

		'php' => 'terminal', 
		'php' => 'file-code-o', 
		'css' => 'css3', 
		'sass' => 'puzzle', 
		'sass-mixin' => 'puzzle', 
		'html' => 'code'
	);

	global $post;

	$taxType = $taxonomy;

	$theTags = wp_get_post_terms($post->ID, $taxType, array(
		
	));
?>

<ul class="tags">
	<?php foreach ($theTags as $theTag) : ?>
		<li>
			<a href="<?php echo get_term_link($theTag) ?>" class="icon-<?php echo isset($tag2ico[$theTag->slug]) ? $tag2ico[$theTag->slug] : $theTag->slug ?>">
				<?php echo $theTag->name ?>
			</a>
		</li>
	<?php endforeach ?>
</ul>

