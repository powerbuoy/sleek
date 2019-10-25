<form method="get" action="<?php echo home_url() ?>" id="search-form">

	<p>
		<label for="search-form-s"><?php _e('Search', 'sleek') ?></label>
		<input type="search" name="s" id="search-form-s" value="<?php echo trim(get_search_query()) ?>" placeholder="<?php _e('Search the site', 'sleek') ?>">
		<button><?php _e('Search', 'sleek') ?></button>
	</p>

</form>
