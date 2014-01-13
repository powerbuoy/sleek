<?php include TEMPLATEPATH . '/modules/head.php' ?>

<header id="header">

	<?php if (is_front_page()) : ?>
		<h1><a href="<?php echo home_url('/') ?>"><?php bloginfo('name') ?></a></h1>
	<?php else : ?>
		<p class="logo"><a href="<?php echo home_url('/') ?>"><?php bloginfo('name') ?></a></p>
	<?php endif ?>

	<p class="tagline"><?php bloginfo('description') ?></p>

	<?php dynamic_sidebar('header') ?>

</header>

<div id="content">
