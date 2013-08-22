<?php include TEMPLATEPATH . '/modules/head.php' ?>

<header id="header">

	<h1><a href="<?php echo home_url('/') ?>"><img src="<?php echo get_template_directory_uri() ?>/css/gfx/logo.png" alt="<?php bloginfo('name') ?>"></a></h1>

	<p><?php bloginfo('description') ?></p>

	<?php dynamic_sidebar('header') ?>

</header>

<div id="content">
