<section id="search-form">

	<?php if ($search_form_title or $search_form_description) : ?>
		<header>

			<?php if ($search_form_title) : ?>
				<h2><?php echo $search_form_title ?></h2>
			<?php endif ?>

			<?php echo $search_form_description ?>

		</header>
	<?php endif ?>

	<?php get_template_part('modules/search-form') ?>

</section>
