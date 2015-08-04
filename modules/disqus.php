<?php global $post ?>

<?php if (defined('DISQUS_SHORTNAME') and comments_open()) : ?>
	<section id="disqus">

		<div id="disqus_thread"></div>

		<script type="text/javascript">
			/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
			var disqus_shortname = '<?php echo DISQUS_SHORTNAME ?>'; // Required - Replace '<example>' with your forum shortname

			<?php if (function_exists('get_field') and $disqusID = get_field('disqus_id')) : ?>
				var disqus_identifier = '<?php echo $disqusID ?>';
			<?php else : ?>
				var disqus_identifier = 'post-<?php echo $post->ID ?>';
			<?php endif ?>

			/* * * DON'T EDIT BELOW THIS LINE * * */
			(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
		</script>

		<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

	</section>
<?php endif ?>
