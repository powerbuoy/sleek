<?php $users = get_users(array(
	'exclude' => array(1) # Ignore admin (ID: 1)
)) ?>

<section id="authors">

	<ul>
		<?php foreach ($users as $usr) : ?>
			<li>
				<h3>
					<a href="<?php echo get_author_posts_url($usr->ID) ?>">
						<img src="http://www.gravatar.com/avatar/<?php echo md5($usr->user_email) ?>?s=150"> 
						<?php echo $usr->display_name ?>
					</a>
				</h3>

				<p>
					<?php echo get_user_meta($usr->ID, 'description', true) ?><br>
					<a href="mailto:<?php echo $usr->user_email ?>"><?php echo $usr->user_email ?></a>
				</p>
			</li>
		<?php endforeach ?>
	</ul>

</section>
