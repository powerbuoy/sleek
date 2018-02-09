<section id="video">

	<?php if ($video_title or $video_description) : ?>
		<header>

			<?php if ($video_title) : ?>
				<h2><?php echo $video_title ?></h2>
			<?php endif ?>

			<?php echo $video_description ?>

		</header>
	<?php endif ?>

	<div class="video"><?php echo $video_code ?></div>

</section>
