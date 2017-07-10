<?php
	$nav = str_replace(
		'<h2 class="screen-reader-text">REMOVE</h2>',
		'',
		get_the_posts_pagination([
			'screen_reader_text' => 'REMOVE'
		]
	));
?>

<nav id="pagination">

	<?php echo $nav ?>

</nav>
