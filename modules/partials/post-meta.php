<p>
	<small>
		<?php if (has_tag()) : ?>
			<?php the_tags() ?> | 
		<?php endif ?>
		<?php edit_post_link(null, null, ' | ') ?>
		<?php comments_popup_link() ?>
	</small>
</p>

<?php /* <p>
	<small>
		Posted on <?php the_time('l, F jS, Y') ?> at <?php the_time() ?>, filed under <?php the_category(', ') ?>. 
		You can follow any responses to this entry through the 
		<?php post_comments_feed_link('RSS 2.0') ?> feed.

		<?php if (('open' == $post-> comment_status) and ('open' == $post->ping_status)) : ?>
			You can <a href="#respond">leave a response</a>, or <a href="<?php trackback_url() ?>" rel="trackback">trackback</a> from your own site.
		<?php elseif (!('open' == $post-> comment_status) and ('open' == $post->ping_status)) : ?>
			Responses are currently closed, but you can <a href="<?php trackback_url() ?> " rel="trackback">trackback</a> from your own site.
		<?php elseif (('open' == $post-> comment_status) and !('open' == $post->ping_status)) : ?>
			You can skip to the end and leave a response. Pinging is currently not allowed.
		<?php elseif (!('open' == $post-> comment_status) and !('open' == $post->ping_status)) : ?>
			Both comments and pings are currently closed.
		<?php endif; edit_post_link('Edit this entry','','.') ?>
	</small>
</p> */ ?>
