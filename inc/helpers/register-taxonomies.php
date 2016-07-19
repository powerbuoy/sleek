<?php
/**
 * Register custom taxonomies
 *
 * Takes $taxonomies as 'slug' => array('custom', 'post_types')
 * Pass in an optional text domain as the second argument (for translating URLs etc)
 */
function sleek_register_taxonomies ($taxonomies, $textdomain = 'sleek') {
	foreach ($taxonomies as $taxonomy => $forPostTypes) {
		# Create the post type slug - if a textdomain is specified make it translatable, otherwise make it dash-separated
		$slug = $textdomain ? __('url_' . $taxonomy, $textdomain) : str_replace('_', '-', $taxonomy);

		# Create the post type nice-name based on the the postType name
		$name = __(ucfirst(str_replace('_', ' ', $taxonomy)), $textdomain);

		# Assume it should be treated as a tag (non hierarchical) if the slug has "tag" in the name
		# TODO: Is this a shit assumtion?? :P
		$hierarchical = strpos($taxonomy, 'tag') !== false ? false : true;

		# Register the taxonomy
		register_taxonomy($taxonomy, $forPostTypes, array(
			'labels' => array(
				'name' => $name,
				'singular_label' => $name
			),
			'rewrite' => array(
				'with_front' => false,
				'slug' => $slug
			),
			'sort' => true,
			'hierarchical' => $hierarchical
		));
	}
}
