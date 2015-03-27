<?php
	if (get_query_var('author_name')) {
		$usr = get_user_by('slug', get_query_var('author_name'));
	}
	else {
		$usr = get_user_by('id', get_query_var('author'));
	}

	if (!$usr) {
		$usr = get_user_by('id', get_the_author_meta('ID'));
	}
?>

<?php if ($usr) : ?>
	<section id="post-author">

		<h2>
			<?php if ($usr->user_url) : ?><a href="<?php echo $usr->user_url ?>"><?php endif ?>
				<?php echo get_avatar($usr->ID) ?> 
				<?php echo $usr->display_name ?>
			<?php if ($usr->user_url) : ?></a><?php endif ?>
		</h2>

		<?php if ($usr->description) : ?>
			<p><?php echo $usr->description ?></p>
		<?php endif ?>

		<p>
			<?php if ($tel = get_user_meta($usr->ID, 'tel', true)) : ?>
				<a href="tel:<?php echo $tel ?>"><?php echo $tel ?></a>
			<?php endif ?>

			<a href="mailto:<?php echo $usr->user_email ?>"><?php echo $usr->user_email ?></a>
		</p>

		<?php /* <nav>
			<ul>
				<?php foreach (array('twitter', 'facebok', 'linkedin', 'googleplus', 'skype') as $sn) : ?>
					<?php if ($snlink = get_the_author_meta($sn, $usr->ID)) : ?>
						<li><a href="<?php echo $snlink ?>"><?php echo ucfirst($sn) ?></a></li>
					<?php endif ?>
				<?php endforeach ?>
			</ul>
		</nav> */ ?>

	</section>
<?php endif ?>
