/**
 * Main JS App
 * Add all your code to this object for it to run onload.
 *
 * If you want to add code that only runs when a certain part of the page
 * is visible, for example #recent-comments, add a new MODULE 
 * with App.modules.RecentComments = {init: function () {}};
 * Note that the module name HAS to correspond to the ID of the
 * element it's tied to. So if you have #header specific code
 * you add it to App.modules.Header, #login-screen: App.modules.LoginScreen and so on.
 *
 * DEPRACATED: 
 * If you want to add code that runs on every page load create
 * a new plugin with App.plugins.MyPlugin = {init: function () {}};
 *
 * Instead just create your own object; ImageZoom = {init: function () ... }; and then call it from the (global) Header-module
 */
App = {
	modules: [], 

	// Init
	init: function() {
		this.initModules();
	}, 

	// Run every module that is currently on the page's init function
	// If you dynamically add or remove modules you can manually run them
	// with App.modules.TheModuleYouJustAdded.init();
	initModules: function() {
		// Run through all modules
		for (var module in this.modules) {
			// Work out the HTML-ID based on the module-name (RecentArticles == recent-articles)
			var id = module.replace(/([A-Z])/g, '-$1').toLowerCase();

			id = id.substring(0, 1) == '-' ? id.substring(1) : id;

			var mod = document.getElementById(id);

			// Only run modules that are used and don't run ajax-run-modules
			if (mod && typeof(this.modules[module].init) == 'function') {
				this.modules[module].init(mod);
			}
		}
	}, 

	utils: {
		loadScript: function (src, callback) {
			var s = document.createElement('script');

			s.src = src;

			document.body.appendChild(s);

			s.addEventListener('load', callback);
		}
	}
};
