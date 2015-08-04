<?php
# This file isn't in use - if you use relevanssi you might find it useful
# Allow empty search
add_filter('request', 'sleek_allow_empty_search');

function sleek_allow_empty_search ($qryVars) {
    if (isset($_GET['s']) and empty($_GET['s'])) {
        $qryVars['s'] = ' ';
    }

    return $qryVars;
}

add_filter('relevanssi_hits_filter', 'sleek_allow_empty_search_filter');

function sleek_allow_empty_search_filter ($hits) {
	if (isset($_GET['s']) and empty($_GET['s']) and !count($hits[0])) {
		$taxQry = array('relation' => 'AND');

		if (!empty($_GET['countries'])) {
			$taxQry[] = array(
				'taxonomy' => 'countries', 
				'field' => 'slug', 
				'terms' => $_GET['countries']
			);
		}

		if (!empty($_GET['specialities'])) {
			$taxQry[] = array(
				'taxonomy' => 'specialities', 
				'field' => 'slug', 
				'terms' => $_GET['specialities']
			);
		}

		$args = array(
			'numberposts' => -1, 
			'post_type' => 'any'
		);

		if (count($taxQry) > 1) {
			$args['tax_query'] = $taxQry;
		}

		$hits[0] = get_posts($args);
	}

	return $hits;
}

# Allow sorting by price
add_filter('relevanssi_hits_filter', 'sleek_hits_filter');

function sleek_hits_filter ($hits) {
	global $wp_query;

	if (isset($wp_query->query_vars['orderby']) and $wp_query->query_vars['orderby'] == 'price') {
		if (count($hits[0])) {
			usort($hits[0], 'sleek_sort_by_price');
		}
	}

	return $hits;
}

function sleek_sort_by_price ($a, $b) {
	$priceKey	= '_simple_fields_fieldGroupID_4_fieldID_3_numInSet_0';
	$aPrice		= get_post_meta($a->ID, $priceKey, true);
	$bPrice		= get_post_meta($b->ID, $priceKey, true);
	$aPrice		= $aPrice ? $aPrice : 10000000;
	$bPrice		= $bPrice ? $bPrice : 10000000;

	if ($aPrice == $bPrice) {
		return 0;
	}

	return ($aPrice < $bPrice) ? -1 : 1;
}
