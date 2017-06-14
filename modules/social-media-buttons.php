<?php $socialMediaButtons = sleek_get_social_media_links() ?>

<nav id="social-media-buttons">

	<ul>
		<?php foreach ($socialMediaButtons as $smb) : ?>
			<li>
				<a href="<?php echo $smb['url'] ?>" class="icon-<?php echo $smb['slug'] ?>" target="_blank">
					<?php echo __($smb['title'], 'sleek') ?>
				</a>
			</li>
		<?php endforeach ?>
	</ul>

</nav>
