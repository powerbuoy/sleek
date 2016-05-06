<?php
/**
 * Add placeholders to comment form
 *
 * http://wordpress.stackexchange.com/questions/62742/add-placeholder-attribute-to-comment-form-fields
 */
# add_filter('comment_form_defaults', 'sleek_comment_form_placeholders');

function sleek_comment_form_placeholders ($fields) {
	# All fields we want to add placeholders to
	$fieldsToReplace = array(
		'author' => __('Name'),
		'email' => __('Email'),
		'url' => __('Website')
	);

	foreach ($fieldsToReplace as $field => $value) {
		# Add asterisk if required
		$required = strstr($fields['fields'][$field], 'required') ? ' *' : '';

		# Insert placeholder
		$fields['fields'][$field] = str_replace(
			'name="' . $field . '"',
			'name="' . $field . '" placeholder="' . $value . $required . '"',
			$fields['fields'][$field]
		);
	}

	# Comment field is special and always required
	$fields['comment_field'] = str_replace(
		'name="comment"',
		'name="comment" placeholder="' . _x('Comment', 'noun') . ' *"',
		$fields['comment_field']
	);

	return $fields;
}
?>
