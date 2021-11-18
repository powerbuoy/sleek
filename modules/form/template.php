<section id="form">

	<?php if ($title or $description) : ?>
		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>
	<?php endif ?>

	<div class="form">

		<?php include get_stylesheet_directory() . '/modules/form/__form.php' ?>

	</div>

</section>
