<?php
	if (get_query_var('author_name')) {
		$usr = get_user_by('slug', get_query_var('author_name'));
	}
	else {
		$usr = get_userdata(get_query_var('author'));
	}
?>

<section id="post-author">

	<h1>
		<?php echo get_avatar($usr->ID) ?> 
		<?php echo $usr->display_name ?>
	</h1>

	<p><?php echo $usr->description ?></p>

	<nav>
		<a href="mailto:<?php echo $usr->user_email ?>"><?php echo $usr->user_email ?></a> 
		<?php if ($usr->user_url) : ?>
			<a href="<?php echo $usr->user_url ?>" target="_blank"><?php echo $usr->user_url ?></a> 
		<?php endif ?>
		<?php if (get_the_author_meta('googleplus', $usr->ID)) : ?>
			<a href="<?php echo get_the_author_meta('googleplus', $usr->ID) ?>" target="_blank"><?php echo get_the_author_meta('googleplus', $usr->ID) ?></a>
		<?php endif ?>
	</nav>

</section>
