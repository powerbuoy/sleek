<?php
/**
 * Adds recaptcha, google analytics etc JS if defined
 */
add_action('wp_footer', 'sleek_add_extra_js');

function sleek_add_extra_js () {
	# ReCaptcha
	if (defined('RECAPTCHA_SITE_KEY') and RECAPTCHA_SITE_KEY and defined('RECAPTCHA_SECRET') and RECAPTCHA_SECRET) {
		echo '<script src="https://www.google.com/recaptcha/api.js?onload=RenderCaptchas&amp;render=explicit" async defer></script>';
	}

	# Google Analytics
	if (defined('GOOGLE_ANALYTICS') and GOOGLE_ANALYTICS) {
		echo "<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', '" . GOOGLE_ANALYTICS . "', 'auto');
			ga('send', 'pageview');
		</script>";
	}

	# Google Tag Manager
	if (defined('GOOGLE_TAG_MANAGER') and GOOGLE_TAG_MANAGER) {
		echo "<script>
			// TODO
		</script>";
	}
}
