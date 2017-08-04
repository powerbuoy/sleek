<?php
# Add custom fields to rest API
add_action('rest_api_init', function () {
	register_rest_field('page', 'custom_fields', ['get_callback' => function () {
		return get_post_custom($post['id']);
	}]);
});
