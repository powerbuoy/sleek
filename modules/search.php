<form method="get" action="<?php echo home_url() ?>" class="search">

	<p>
		<input type="search" name="s" value="<?php echo trim(get_search_query()) ?>" placeholder="<?php _e('Search...', 'sleek') ?>">
		<button type="submit"><?php _e('Find', 'sleek') ?></button>
	</p>

</form>
