<?php
if (!class_exists('SleekMenuItemMetaWalker')) {
	class SleekMenuItemMetaWalker extends Walker_Nav_Menu {
		function start_el (&$output, $item, $depth = 0, $args = [], $id = 0) {
			parent::start_el($output, $item, $depth, $args, $id);

			$taxonomies = '';
			$childPages = '';

			# Insert taxonomies
			if ($tax = get_field('menu_item_meta_taxonomy', $item)) {
				$args = [
					'taxonomy' => $tax,
					'title_li' => false,
					'show_option_all' => false,
					'echo' => false,
					'hide_empty' => true
				];

				if ($depth = get_field('menu_item_meta_taxonomy_depth', $item)) {
					$args['depth'] = $depth;
				}

				$taxonomies = '<ul class="terms">' . wp_list_categories($args) . '</ul>';

				if (strpos($taxonomies, 'cat-item-none') !== false) {
					$taxonomies = '';
				}
			}

			# Insert child pages
			if (get_field('menu_item_meta_child_pages', $item) and $item->type == 'post_type') {
				$args = [
					'post_type' => $item->object,
					'child_of' => $item->object_id,
					'echo' => false,
					'link_before' => '',
					'link_after' => '',
					'title_li' => ''
				];

				if ($depth = get_field('menu_item_meta_child_pages_depth', $item)) {
					$args['depth'] = $depth;
				}

				$childPages = '<ul class="child-pages">' . wp_list_pages($args) . '</ul>';
			}

			$output .= $taxonomies . $childPages;
		}
	}
}

$taxs = get_taxonomies(['public' => true], 'object');
$taxonomies = [
	'none' => __('None', 'sleek')
];

foreach ($taxs as $tax) {
	$taxonomies[$tax->name] = $tax->label;
}

return [
	[
		'name' => 'menu_item_meta_child_pages',
		'label' => __('Child pages', 'sleek'),
		'type' => 'true_false',
		'message' => __('Show child pages', 'sleek')
	],
	[
		'name' => 'menu_item_meta_child_pages_depth',
		'label' => __('Child page depth', 'sleek'),
		'type' => 'number'
	],
	[
		'name' => 'menu_item_meta_taxonomy',
		'label' => __('Taxonomy', 'sleek'),
		'type' => 'radio',
		'choices' => $taxonomies
	],
	[
		'name' => 'menu_item_meta_taxonomy_depth',
		'label' => __('Taxonomy depth', 'sleek'),
		'type' => 'number'
	]
];
