<nav id="share-post">

	<ul>
		<?php foreach (sleek_get_social_media_links() as $smb) : ?>
			<li>
				<a href="<?php echo $smb['url'] ?>" class="icon-<?php echo $smb['slug'] ?>" target="_blank">
					<?php echo __($smb['title'], 'sleek') ?>
				</a>
			</li>
		<?php endforeach ?>
	</ul>

</nav>
