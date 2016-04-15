<?php
# Add placeholders to comment form
# http://wordpress.stackexchange.com/questions/62742/add-placeholder-attribute-to-comment-form-fields
# add_filter('comment_form_defaults', 'sleek_comment_form_placeholders');

function sleek_comment_form_placeholders ($fields) {
	$fields['fields']['author'] = str_replace(
		'name="author"',
		'name="author" placeholder="' . __('Name') . '"',
		$fields['fields']['author']
	);
	$fields['fields']['email'] = str_replace(
		'name="email"',
		'name="email" placeholder="' . __('Email') . '"',
		$fields['fields']['email']
	);
	$fields['fields']['url'] = str_replace(
		'name="url"',
		'name="url" placeholder="' . __('Website') . '"',
		$fields['fields']['url']
	);
	$fields['comment_field'] = str_replace(
		'name="comment"',
		'name="comment" placeholder="' . _x('Comment', 'noun') . '"',
		$fields['comment_field']
	);

	return $fields;
}
?>
