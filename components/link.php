<?php
	$args = array_merge([
		'link' => null,
		'title' => 'N/A'
	], $args);

	# Array
	if (!empty($args['link']['url'])) {
		echo
			'<a href="' . $args['link']['url'] . '"' .
			(
				empty($args['link']['target']) ?
					'' :
					'target="' . $args['link']['target'] . '" rel="nofollower"'
			) .
			'>' .
			$args['title'] .
			'</a>';
	}
	# String
	elseif (!empty($args['link'])) {
		echo '<a href="' . $args['link'] . '">' . $args['title'] . '</a>';
	}
	# No link found
	else {
		echo $args['title'];
	}
?>