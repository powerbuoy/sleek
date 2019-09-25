<?php if ($links) : ?>
	<nav id="social-links">

		<ul>
			<?php foreach ($links as $link) : ?>
				<li>
					<a href="<?php echo $link->url ?>" target="_blank" rel="noopener">
						<?php echo $link->name ?>
					</a>
				</li>
			<?php endforeach ?>
		</ul>

	</nav>
<?php endif ?>
