'use strict';

// Import CSS
import '../sass/app.scss';

// Import our JS
import './*.js';

// Import Module JS
// import '../../modules/**/*.js';

// Import Vue Components
// TODO: Auto-import all .vue files and register them using require.context()
import ToDo from './todo.vue';

// Init Vue on all [data-vue] elements
document.querySelectorAll('[data-vue]').forEach(el => {
	new Vue({
		el: el,
		components: {
			'todo': ToDo
		}
	});
});
