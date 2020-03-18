<section id="attachments">

	<?php if ($title or $description) : ?>
		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>
	<?php endif ?>

	<ul>
		<?php foreach ($files as $file) : ?>
			<?php $url = wp_get_attachment_url($file['files_file']) ?>
			<li>
				<a href="<?php echo $url ?>">
					<?php echo get_the_title($file['files_file']) ?>
					<small>
						(<?php echo wp_check_filetype($url)['ext'] ?>,
						<?php echo size_format(filesize(get_attached_file($file['files_file']))) ?>)
					</small>
				</a>
			</li>
		<?php endforeach ?>
	</ul>

</section>
