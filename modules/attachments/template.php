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
			<li>
				<a href="<?php echo $file['files_file']['url'] ?>">
					<?php echo $file['files_file']['title'] ?>
					<small>
						(<?php echo wp_check_filetype($file['files_file']['filename'])['ext'] ?>,
						<?php echo size_format(filesize(get_attached_file($file['files_file']['id']))) ?>)
					</small>
				</a>
			</li>
		<?php endforeach ?>
	</ul>

</section>
