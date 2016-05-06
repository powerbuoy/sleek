<?php
/**
 * Register custom taxonomies
 *
 * Takes $taxonomies as 'slug' => array('custom', 'post_types')
 * Pass in an optional text domain as the second argument (for translating URLs etc)
 */
function sleek_register_taxonomies ($taxonomies, $textdomain = 'sleek') {
	foreach ($taxonomies as $taxonomy => $forPostTypes) {
		# Assume it should be treated as a tag (non hierarchical) if the slug has "tag" in the name
		# $hierarchical = strpos($taxonomy, 'tag') !== false ? false : true;
		$hierarchical = false;

		register_taxonomy($taxonomy, $forPostTypes, array(
			'labels'			=> array(
				'name'			=> __(ucfirst(str_replace('_', ' ', $taxonomy)), $textdomain),
				'singular_label'=> __(ucfirst(str_replace('_', ' ', $taxonomy)), $textdomain)
			),
			'rewrite'			=> array(
				'with_front'	=> false,
				'slug'			=> __('url_' . $taxonomy, $textdomain)
			),
			'sort'				=> true,
			'hierarchical'		=> $hierarchical
		));
	}
}
