<?php
# add_action('wp_head', 'sleek_open_graph_tags');

function sleek_open_graph_tags () {
	global $post;

	if (is_single()) {
		$ogTags = array(
			'og:title' => htmlspecialchars(get_the_title()),
			'og:description' => htmlspecialchars(strip_tags(sleek_get_the_excerpt($post->ID))),
			'og:type' => 'article',
			'og:url' => get_permalink(),
			'og:site_name' => htmlspecialchars(get_bloginfo('name'))
		);

		if (has_post_thumbnail()) {
			$ogTags['og:image'] = get_the_post_thumbnail_url();
		}

		foreach ($ogTags as $ogTag => $ogVal) {
			echo '<meta property="' . $ogTag . '" content="' . $ogVal . '">';
		}
	}
}
?>
