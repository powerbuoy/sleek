<?php
function sleek_disable_single_post_types ($postTypes) {
    global $post;

    $queriedPT = get_query_var('post_type');

    if (is_single() && in_array($queriedPT, $postTypes)) {
        wp_redirect(get_post_type_archive_link($queriedPT));
    }
}
