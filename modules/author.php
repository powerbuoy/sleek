<?php $curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author')) ?>

<section id="author">

	<h2>
		<img src="http://www.gravatar.com/avatar/<?php echo md5($curauth->user_email) ?>">
		<?php echo $curauth->display_name ?>
	</h2>

	<p><?php echo $curauth->description ?></p>

	<nav>
		<a href="mailto:<?php echo $curauth->user_email ?>" class="email">
			<?php echo $curauth->user_email ?>
		</a> 
		<?php if ($curauth->user_url) : ?>
			<a href="<?php echo $curauth->user_url ?>" class="url">
				<?php echo $curauth->user_url ?>
			</a>
		<?php endif ?>
	</nav>

</section>
