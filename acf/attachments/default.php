<section id="attachments">

	<?php if ($attachments_title or $attachments_description) : ?>
		<header>

			<?php if ($attachments_title) : ?>
				<h2><?php echo $attachments_title ?></h2>
			<?php endif ?>

			<?php echo $attachments_description ?>

		</header>
	<?php endif ?>

	<ul>
		<?php foreach ($attachments_files as $file) : ?>
			<li>
				<a href="<?php echo $file['attachments_files_file']['url'] ?>">
					<?php echo $file['attachments_files_file']['title'] ?>
					<small>
						(<?php echo wp_check_filetype($file['attachments_files_file']['filename'])['ext'] ?>,
						<?php echo size_format(filesize(get_attached_file($file['attachments_files_file']['id']))) ?>)
					</small>
				</a>
			</li>
		<?php endforeach ?>
	</ul>

</section>
