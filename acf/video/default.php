<section id="video">

	<?php if ($data['video-title'] or $data['video-description']) : ?>
		<header>

			<?php if ($data['video-title']) : ?>
				<h2><?php echo $data['video-title'] ?></h2>
			<?php endif ?>

			<?php echo $data['video-description'] ?>

		</header>
	<?php endif ?>

	<div class="video"><?php echo $data['video-code'] ?></div>

</section>
