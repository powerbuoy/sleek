<?php $archiveData = sleek_get_archive_data([
	'image_size' => 'large'
]) ?>

<?php if ($archiveData) : ?>
	<header id="archive-header">

		<?php if ($archiveData['image']) : ?>
			<figure>
				<img src="<?php echo $archiveData['image'] ?>">
			</figure>
		<?php endif ?>

		<?php if ($archiveData['title']) : ?>
			<h1><?php echo $archiveData['title'] ?></h1>
		<?php endif ?>

		<?php echo $archiveData['content'] ?>

	</header>
<?php endif ?>
