<form method="get" action="<?php echo home_url() ?>" class="quick-search dont-validate">

	<p>
		<input type="text" name="s" value="<?php echo trim(get_search_query()) ?>" placeholder="<?php _e('Search...', 'h5b') ?>"> 
		<input type="submit" value="<?php _e('Find', 'h5b') ?>">
	</p>

</form>
