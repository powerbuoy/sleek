H5B = {
	init: function() {
		this.initPlugins();
		this.initModules();

		// TEMP
		var icons = ['icon-user', 'icon-ok', 'icon-remove', 'icon-zoom-in', 'icon-cog', 'icon-trash', 'icon-time'];

		$('#primary-nav').find('a').each(function (i) {
			$(this).addClass(icons[i]).addClass('large');

			if (i % 2) {
				$(this).addClass('after');
			}
		});
	}, 

	initPlugins: function() {
		for (var plugin in this.plugins) {
			if (typeof(this.plugins[plugin].init) == 'function') {
				this.plugins[plugin].init();
			}
		}
	}, 

	initModules: function() {
		// Run through all modules
		for (var module in this.modules) {
			// Work out the HTML-ID based on the module-name (RecentArticles == recent-articles)
			var id = module.replace(/([A-Z])/g, '-$1').toLowerCase();

			id = id.substring(0, 1) == '-' ? id.substring(1) : id;

			var mod = jQuery('#' + id);

			// Only run modules that are used and don't run ajax-run-modules
			if (mod.length && typeof(this.modules[module].init) == 'function') {
				this.modules[module].init(mod);
			}
		}
	}, 

	modules: [], 
	plugins: []
};

$(function () {
	H5B.init();
});
