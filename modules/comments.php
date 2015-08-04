<?php if (have_comments()) : ?>
	<section id="comments">

		<?php if (post_password_required()) : ?>
			<p><strong><?php _e('This post is password protected. Enter the password to view comments.', 'sleek') ?></strong></p>
		<?php return; endif ?>

		<?php if (have_comments()) : ?>
			<h2>
				<?php comments_number(
					sprintf(__('No comments on "%s"', 'sleek'), get_the_title()), 
					sprintf(__('One comment on "%s"', 'sleek'), get_the_title()), 
					sprintf(__('%% comments on "%s"', 'sleek'), get_the_title())
				)?> 
			</h2>

			<ol>
				<?php wp_list_comments(); ?>
			</ol>

			<nav>
				<?php previous_comments_link() ?>
				<?php next_comments_link() ?>
			</nav>
		<?php else : ?>
			<?php if (comments_open()) : ?>
				<p><?php _e('No comments yet, why not <a href="#post-comment">post the first</a>?', 'sleek') ?></p>
			<?php else : ?>
				<p><strong><?php _e('Comments are closed.', 'sleek') ?></strong></p>
			<?php endif ?>
		<?php endif ?>

	</section>

<?php endif ?>

<?php if (comments_open()) : ?>
	<section id="post-comment">

		<?php comment_form() ?>

	</section>
<?php endif ?>
