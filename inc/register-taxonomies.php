<?php
/**
 * Register custom taxonomies
 *
 * Takes $taxonomies as 'slug' => array('custom', 'post_types')
 * Pass in an optional text domain as the second argument (for translating URLs etc)
 */
function sleek_register_taxonomies ($taxonomies, $textdomain = false) {
	foreach ($taxonomies as $taxonomy => $forPostTypes) {
		# Store plural version of name
		$plural = sleek_pluralize($taxonomy);

		# Create the post type slug - if a textdomain is specified make it translatable, otherwise make it dash-separated
		$slug = $textdomain ? _x(str_replace('_', '-', $plural), 'url', $textdomain) : str_replace('_', '-', $plural);

		# Create the taxonomy nice-name based on the the taxonomy name
		$name = ucfirst(str_replace('_', ' ', $taxonomy));

		# Assume it should be treated as a tag (non hierarchical) if the slug has "tag" in the name
		# TODO: Is this a shit assumtion?? :P Maybe, and at least do /_tag$/
		$hierarchical = strpos($taxonomy, 'tag') !== false ? false : true;

		# Register the taxonomy
		register_taxonomy($taxonomy, $forPostTypes, [
			'labels' => [
				'name' => __(sleek_pluralize($name), $textdomain),
				'singular_name' => __($name, $textdomain)
			],
			'rewrite' => [
				'with_front' => false,
				'slug' => $slug,
				'hierarchical' => $hierarchical
			],
			'sort' => true,
			'hierarchical' => $hierarchical,
			'show_in_rest' => true
		]);
	}
}
