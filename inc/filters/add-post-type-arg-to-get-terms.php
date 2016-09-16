<?php
/**
 * Handle the post_type parameter given in get_terms function
 * https://www.dfactory.eu/get_terms-post-type/
 */
# add_filter('terms_clauses', 'sleek_terms_clauses', 10, 3);

function sleek_terms_clauses ($clauses, $taxonomy, $args) {
	if (!empty($args['post_type']))	{
		global $wpdb;

		$post_types = [];

		foreach ($args['post_type'] as $cpt)	{
			$post_types[] = "'" . $cpt . "'";
		}

		if (!empty($post_types))	{
			$clauses['fields'] = 'DISTINCT ' . str_replace('tt.*', 'tt.term_taxonomy_id, tt.term_id, tt.taxonomy, tt.description, tt.parent', $clauses['fields']) . ', COUNT(t.term_id) AS count';
			$clauses['join'] .= ' INNER JOIN ' . $wpdb->term_relationships . ' AS r ON r.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN ' . $wpdb->posts . ' AS p ON p.ID = r.object_id';
			$clauses['where'] .= ' AND p.post_type IN (' . implode(',', $post_types) . ')';
			$clauses['orderby'] = 'GROUP BY t.term_id ' . $clauses['orderby'];
		}
	}

	return $clauses;
}
