<?php
	$title = str_replace(array('&lt;', '&gt;'), array('<', '>'), get_bloginfo('name'));
	$tagline = str_replace(array('&lt;', '&gt;'), array('<', '>'), get_bloginfo('description'));
?>

<header id="header">

	<?php if (is_front_page()) : ?>
		<h1><a href="<?php echo home_url('/') ?>"><?php echo $title ?></a></h1>
	<?php else : ?>
		<p class="logo"><a href="<?php echo home_url('/') ?>"><?php echo $title ?></a></p>
	<?php endif ?>

	<?php if ($tagline) : ?>
		<p class="tagline"><?php echo $tagline ?></p>
	<?php endif ?>

	<?php dynamic_sidebar('header') ?>

</header>
