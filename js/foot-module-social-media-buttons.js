App.modules.SocialMediaButtons = {
	init: function (mod) {
		var path		= window.location.pathname;
		var countURL	= window.location.origin + path;

		// Twitter
		var twitterHTML = '<a href="https://twitter.com/share?via=conversionista&count=vertical&lang=en" class="twitter-share-button" data-counturl="' 
				+ countURL 
				+ '" data-url="' 
				+ countURL 
				+ '">Tweet</a>';

		// Facebook
		var facebookHTML = '<div class="fb-like" data-href="' 
				+ countURL 
				+ '" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>';

		// Google+
		var googlePlusHTML = '<div class="g-plusone" data-size="tall" data-annotation="bubble" data-href=' 
				+ countURL 
				+ '></div>';

		mod.innerHTML = twitterHTML + facebookHTML + googlePlusHTML;

		// Twitter
		window.twttr = (function (d, s, id) {
			var t, js, fjs = d.getElementsByTagName(s)[0];

			if (d.getElementById(id)) return;

			js = d.createElement(s); 
			js.id = id; 
			js.src= "https://platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js, fjs);

			return window.twttr || (t = { _e: [], ready: function (f) { t._e.push(f) } });
		}(document, "script", "twitter-wjs"));

		// Facebook
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];

			if (d.getElementById(id)) return;

			js = d.createElement(s);
			js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=624972374235609&version=v2.0";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		// Google+
		(function() {
			var po = document.createElement('script');

			po.type = 'text/javascript';
			po.async = true;
			po.src = 'https://apis.google.com/js/platform.js';

			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(po, s);
		})();
	}
};
