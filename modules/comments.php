<?php if (have_comments()) : ?>
	<section id="comments">

		<?php if (post_password_required()) : ?>
			<p><strong><?php _e('This post is password protected. Enter the password to view comments.', 'sleek') ?></strong></p>
		<?php return; endif ?>

		<?php if (have_comments()) : ?>
			<h3>
				<?php comments_number(__('No comments', 'sleek'), __('One comment', 'sleek'), __('% comments', 'sleek')) ?> 
				<?php _e('on', 'sleek') ?> 
				&#8220;<?php the_title(); ?>&#8221;
			</h3>

			<nav>
				<?php previous_comments_link() ?>
				<?php next_comments_link() ?>
			</nav>

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
