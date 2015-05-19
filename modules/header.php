<header id="header">

	<?php if (is_front_page()) : ?>
		<h1><a href="<?php echo home_url('/') ?>"><?php bloginfo('name') ?></a></h1>
	<?php else : ?>
		<p class="logo"><a href="<?php echo home_url('/') ?>"><?php bloginfo('name') ?></a></p>
	<?php endif ?>

	<?php if ($tagline = get_bloginfo('description')) : ?>
		<p class="tagline"><?php echo $tagline ?></p>
	<?php endif ?>

	<?php dynamic_sidebar('header') ?>

</header>
