<?php
/**
 * Returns an array of terms
 */
function sleek_get_post_terms ($id, $pt, $linked = false, $type = 'category', $field = 'name') {
	$terms = [];
	$tmp = false;

	# Convert tag to correct tax name
	if ($pt == 'post' and $type == 'tag') {
		$tmp = wp_get_post_terms($id, 'post_tag');
	}
	# And category...
	elseif ($pt == 'post' and $type == 'category') {
		$tmp = wp_get_post_terms($id, 'category');
	}
	# Custom taxonomies are assumed to be named post-type-name_category
	elseif (taxonomy_exists($pt . '_' . $type)) {
		$tmp = wp_get_post_terms($id, $pt . '_' . $type);
	}
	# Also check to see if this pt has the category taxonomy
	elseif ($type == 'category' and is_object_in_taxonomy($pt, 'category')) {
		$tmp = wp_get_post_terms($id, 'category');
	}
	# Also check to see if this pt has the tag taxonomy
	elseif ($type == 'tag' and is_object_in_taxonomy($pt, 'post_tag')) {
		$tmp = wp_get_post_terms($id, 'post_tag');
	}

	if ($tmp) {
		foreach ($tmp as $t) {
			if ($linked) {
				$terms[] = '<a href="' . get_term_link($t) . '">' . $t->{$field} . '</a>';
			}
			else {
				$terms[] = $t->{$field};
			}
		}
	}

	return $terms;
}
