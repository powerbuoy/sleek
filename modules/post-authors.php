<?php $users = get_users(array(
	'exclude' => array(1) # Ignore admin (ID: 1)
)) ?>

<section id="post-authors">

	<ul>
		<?php foreach ($users as $usr) : ?>
			<li>
				<h2>
					<a href="<?php echo get_author_posts_url($usr->ID) ?>">
						<?php echo get_avatar($usr->ID) ?> 
						<?php echo $usr->display_name ?>
					</a>
				</h2>

				<p>
					<?php echo get_user_meta($usr->ID, 'description', true) ?><br>
					<a href="mailto:<?php echo $usr->user_email ?>"><?php echo $usr->user_email ?></a>
				</p>
			</li>
		<?php endforeach ?>
	</ul>

</section>
