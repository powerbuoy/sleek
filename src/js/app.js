import "./*.js";
import TestComponent from "./test-component.vue";
import AnotherComponent from "./another-component.vue";
// import "../../vendor/powerbuoy/**/*.js";
// import "../../modules/**/*.js";

document.querySelectorAll('[data-vue]').forEach(el => {
	new Vue({
		el: el,
		components: {
			'test-component': TestComponent,
			'another-component': AnotherComponent
		}
	});
});
