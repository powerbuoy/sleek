<?php
/***
The Latest Posts module shows the X latest posts from any post type you select. It automatically updates as you add or remove posts.
***/
# TODO: get_post_types() only returns built in post types at this point in the code :/
# TODO: Add support for choosing a taxonomy as well (must depend on which post type is chosen too...)
$ignore = ['page', 'attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'acf-field-group', 'acf-field', 'wpcf7_contact_form'];
$tmp = get_post_types();
$tmp = array_diff($tmp, $ignore);
$postTypes = [];

foreach ($tmp as $pt) {
	$postTypes[$pt] = get_post_type_object($pt)->labels->name;
}

return [
	[
		'name' => 'latest-posts-title',
		'label' => __('Title', 'sleek_child'),
		'instructions' => __('Enter a title above the list of posts.', 'sleek_child'),
		'type' => 'text'
	],
	[
		'name' => 'latest-posts-description',
		'label' => __('Description', 'sleek_child'),
		'instructions' => __('Enter a description for the posts here.', 'sleek_child'),
		'type' => 'wysiwyg',
		'media_upload' => false
	],
	[
		'name' => 'latest-posts-post-type',
		'label' => __('Post Type', 'sleek_child'),
		'instructions' => __('Select the type of post you would like to display.', 'sleek_child'),
		'type' => 'select',
		'choices' => $postTypes,
		'allow_null' => true,
		'default_value' => 'any',
		'multiple' => true,
		'ui' => true
	],
	[
		'name' => 'latest-posts-limit',
		'label' => __('Number of Posts', 'sleek_child'),
		'instructions' => __('How many posts would you like to display?', 'sleek_child'),
		'type' => 'number',
		'default_value' => 4
	]
];
