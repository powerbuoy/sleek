// Import CSS
import '../sass/app.scss';

// Import vendor JS
import "../../vendor/powerbuoy/**/*.js";

// Import our JS
import './*.js';

// Import Module JS
// import '../../modules/**/*.js';

// Import Vue Components
// TODO: Auto-import all .vue files and register them using require.context()
import VueComponent from './vue-component.vue';

// Init Vue on all [data-vue] elements
document.querySelectorAll('[data-vue]').forEach(el => {
	new Vue({
		el: el,
		components: {
			'vue-component': VueComponent
		}
	});
});
