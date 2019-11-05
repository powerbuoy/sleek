<section id="users">

	<?php if ($title or $description) : ?>
		<header>

			<?php if ($title) : ?>
				<h2><?php echo $title ?></h2>
			<?php endif ?>

			<?php echo $description ?>

		</header>
	<?php endif ?>

	<?php foreach ($users as $user) : ?>
		<article>

			<figure>
				<?php echo get_avatar($user['ID'], 320) ?>
			</figure>

			<header>

				<h3><?php echo $user['display_name'] ?></h3>

				<?php if ($tagline = get_user_meta($user['ID'], 'tagline', true)) : ?>
					<p><?php echo $tagline ?></p>
				<?php endif ?>

			</header>

			<?php echo wpautop($user['user_description']) ?>

			<nav>

				<a href="mailto:<?php echo $user['user_email'] ?>"><?php echo $user['user_email'] ?></a>

				<?php if ($link = get_user_meta($user['ID'], 'phone', true)) : ?>
					<a href="tel:<?php echo $link ?>"><?php echo $link ?></a>
				<?php endif ?>

				<?php if ($user['user_url']) : ?>
					<a href="<?php echo $user['user_url'] ?>" target="_blank" rel="noopener"><?php echo $user['user_url'] ?></a>
				<?php endif ?>

				<?php if ($link = get_user_meta($user['ID'], 'facebook', true)) : ?>
					<a href="//www.facebook.com/<?php echo $link ?>" target="_blank" rel="noopener"><?php echo $link ?></a>
				<?php endif ?>

				<?php if ($link = get_user_meta($user['ID'], 'twitter', true)) : ?>
					<a href="//twitter.com/<?php echo $link ?>" target="_blank" rel="noopener"><?php echo $link ?></a>
				<?php endif ?>

				<?php if ($link = get_user_meta($user['ID'], 'linkedin', true)) : ?>
					<a href="//www.linkedin.com/in/<?php echo $link ?>" target="_blank" rel="noopener"><?php echo $link ?></a>
				<?php endif ?>

				<?php if ($link = get_user_meta($user['ID'], 'instagram', true)) : ?>
					<a href="//www.instagram.com/<?php echo $link ?>" target="_blank" rel="noopener"><?php echo $link ?></a>
				<?php endif ?>

				<?php if ($link = get_user_meta($user['ID'], 'googleplus', true)) : ?>
					<a href="//plus.google.com/<?php echo $link ?>" target="_blank" rel="noopener"><?php echo $link ?></a>
				<?php endif ?>

			</nav>

		</article>
	<?php endforeach ?>

</section>
