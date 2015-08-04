<form method="get" action="<?php echo home_url() ?>" class="search">

	<p>
		<input type="search" name="s" value="<?php echo trim(get_search_query()) ?>" placeholder="<?php _e('Search...', 'sleek') ?>"> 
		<input type="submit" value="<?php _e('Find', 'sleek') ?>">
	</p>

</form>
