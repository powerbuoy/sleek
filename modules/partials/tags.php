<?php
	$tag2ico = array(
		'design' => 'apple', 
		'responsive' => 'crop', 
		'rwd' => 'crop', 

		'wordpress' => 'wordpress', 
		'wordpress-plugin' => 'wordpress', 
		'font-awesome' => 'star', 
		'geo-location' => 'globe', 
		'map' => 'map-marker', 
		'maps' => 'map-marker', 

		'php' => 'terminal', 
		'php' => 'file-code-o', 
		'css' => 'css3', 
		'sass' => 'file-code-o', 
		'sass-mixin' => 'puzzle-piece', 
		'html' => 'code'
	);

	global $post;

	$taxType = $taxonomy;

	$theTags = wp_get_post_terms($post->ID, $taxType, array(
		
	));
?>

<?php if ($theTags) : ?>
	<ul class="tags">
		<?php foreach ($theTags as $theTag) : ?>
			<li>
				<a href="<?php echo get_term_link($theTag) ?>" class="icon-<?php echo isset($tag2ico[$theTag->slug]) ? $tag2ico[$theTag->slug] : $theTag->slug ?>">
					<?php echo $theTag->name ?>
				</a>
			</li>
		<?php endforeach ?>
	</ul>
<?php endif ?>
