<?php include TEMPLATEPATH . '/modules/head.php' ?>

<header id="header">

	<h1><a href="<?php echo home_url('/') ?>"><?php bloginfo('name') ?></a></h1>

	<p><?php bloginfo('description') ?></p>

	<?php dynamic_sidebar('header') ?>

</header>

<div id="content">
