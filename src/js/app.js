'use strict';

///////////////////
// Import polyfills
// querySelector(':scope')
/* import 'element-qsa-scope';

// Scroll-behavior
import smoothscroll from 'smoothscroll-polyfill';
smoothscroll.polyfill();
import 'smoothscroll-anchor-polyfill';

// :has() pseudo class
import cssHasPseudo from 'css-has-pseudo';

cssHasPseudo(document); */

//////////
// CountTo
/* import CountTo from 'sleek-ui/src/js/count-to';

document.querySelectorAll('[data-count-to]').forEach(el => {
	new CountTo(el, {
		from: 0,
		to: el.dataset.countTo,
		prefix: el.dataset.prefix || '',
		suffix: el.dataset.suffix || '',
		duration: 2,
		locale: 'sv-SE'
	}).mount();
}); */

//////////////////
// DocumentOutline
/* import DocumentOutline from 'sleek-ui/src/js/document-outline';

document.querySelectorAll('[data-document-outline]').forEach(el => {
	el.innerHTML = new DocumentOutline(document.querySelector(el.dataset.documentOutline)).generateOutline();
}); */

//////////////
// FilterItems
/* import FilterItems from 'sleek-ui/src/js/filter-items';

document.querySelectorAll('[data-filter-items]').forEach(el => {
	new FilterItems(el, document.querySelectorAll(el.dataset.filterItems)).mount();
}); */

/////////////////
// RadialProgress
// TODO
/* import RadialProgress from 'sleek-ui/src/js/radial-progress';

document.querySelectorAll('[data-radial-progress]').forEach(el => {
	const radPro = new RadialProgress(el, parseInt(el.dataset.radialProgress || 0));

	radPro.mount();

	setTimeout(() => {
		radPro.value = parseInt(el.dataset.to || 0);
	}, 3000);
}); */

//////////////
// ScrollStats
/* import ScrollStats from 'sleek-ui/src/js/scroll-stats';

new ScrollStats({farThreshold: 100}).mount(); */

////////////
// Scrollspy
/* import Scrollspy from 'sleek-ui/src/js/scrollspy';

document.querySelectorAll('[data-scrollspy]').forEach(el => {
	new Scrollspy(el, {threshold: 0.75}).mount();
}); */

/////////////////
// SubmitOnChange
/* import SubmitOnchange from 'sleek-ui/src/js/submit-onchange';

document.querySelectorAll('[data-submit-onchange]').forEach(el => {
	new SubmitOnchange(el).mount();
}); */

/////////////
// ToggleHash
/* import ToggleHash from 'sleek-ui/src/js/toggle-hash';

document.querySelectorAll('[data-toggle-hash]').forEach(el => {
	new ToggleHash(el, {
		toggleText: el.dataset.toggleHash || el.innerText
	}).mount();
}); */

/////////
// Dialog
import Dialog, { DialogTrigger } from 'sleek-ui/src/js/dialog';

const templateDialog = document.createElement('div');
templateDialog.classList.add('dialog');
document.body.appendChild(templateDialog);

document.querySelectorAll('a[href^="#dialog-"]').forEach(el => {
	new DialogTrigger(el, {
		target: document.getElementById(el.getAttribute('href').substr(1)),
		templateDialog: templateDialog
	}).mount();
});

document.querySelectorAll('div.dialog').forEach(el => {
	new Dialog(el).mount();
});

////////////
// Slideshow
/* import Slideshow from 'sleek-ui/src/js/slideshow';

document.querySelectorAll('[data-slideshow]').forEach(el => {
	var args = el.dataset.slideshow;

	if (args) {
		try {
			args = JSON.parse(args);
		}
		catch {
			args = {};
		}
	}
	else {
		args = {};
	}

	new Slideshow(el, args).mount();
}); */

//////////////
// Google Maps
/* import GoogleMap from 'sleek-ui/src/js/google-map';

if (typeof window.SLEEK_GOOGLE_MAPS_API_KEY !== 'undefined') {
	window.googleMapsInit = () => {
		const observer = new IntersectionObserver(entries => {
			entries.forEach(entry => {
				if (entry.isIntersecting && !entry.target.classList.contains('google-map-loaded')) {
					entry.target.classList.add('google-map-loaded');

					let mapConfig = GoogleMap.parseMapEl(entry.target);

					// Add a style (unless already added in map HTML): https://mapstyle.withgoogle.com/
					if (!mapConfig.styles) {
						mapConfig.styles = [{"elementType": "geometry","stylers": [{"color": "#ebe3cd"}]},{"elementType": "labels.text.fill","stylers": [{"color": "#523735"}]},{"elementType": "labels.text.stroke","stylers": [{"color": "#f5f1e6"}]},{"featureType": "administrative","elementType": "geometry.stroke","stylers": [{"color": "#c9b2a6"}]},{"featureType": "administrative.land_parcel","elementType": "geometry.stroke","stylers": [{"color": "#dcd2be"}]},{"featureType": "administrative.land_parcel","elementType": "labels.text.fill","stylers": [{"color": "#ae9e90"}]},{"featureType": "landscape.natural","elementType": "geometry","stylers": [{"color": "#dfd2ae"}]},{"featureType": "poi","elementType": "geometry","stylers": [{"color": "#dfd2ae"}]},{"featureType": "poi","elementType": "labels.text.fill","stylers": [{"color": "#93817c"}]},{"featureType": "poi.park","elementType": "geometry.fill","stylers": [{"color": "#a5b076"}]},{"featureType": "poi.park","elementType": "labels.text.fill","stylers": [{"color": "#447530"}]},{"featureType": "road","elementType": "geometry","stylers": [{"color": "#f5f1e6"}]},{"featureType": "road.arterial","elementType": "geometry","stylers": [{"color": "#fdfcf8"}]},{"featureType": "road.highway","elementType": "geometry","stylers": [{"color": "#f8c967"}]},{"featureType": "road.highway","elementType": "geometry.stroke","stylers": [{"color": "#e9bc62"}]},{"featureType": "road.highway.controlled_access","elementType": "geometry","stylers": [{"color": "#e98d58"}]},{"featureType": "road.highway.controlled_access","elementType": "geometry.stroke","stylers": [{"color": "#db8555"}]},{"featureType": "road.local","elementType": "labels.text.fill","stylers": [{"color": "#806b63"}]},{"featureType": "transit.line","elementType": "geometry","stylers": [{"color": "#dfd2ae"}]},{"featureType": "transit.line","elementType": "labels.text.fill","stylers": [{"color": "#8f7d77"}]},{"featureType": "transit.line","elementType": "labels.text.stroke","stylers": [{"color": "#ebe3cd"}]},{"featureType": "transit.station","elementType": "geometry","stylers": [{"color": "#dfd2ae"}]},{"featureType": "water","elementType": "geometry.fill","stylers": [{"color": "#b9d3c2"}]},{"featureType": "water","elementType": "labels.text.fill","stylers": [{"color": "#92998d"}]}];
					}

					// TODO: Add a default marker icon support in sleek-map
					if (!mapConfig.markerIcon) {
						mapConfig.markerIcon = '...';
					}

					entry.target.sleekMap = new GoogleMap(entry.target, mapConfig);
				}
			});
		}, {threshold: .25});

		document.querySelectorAll('.google-map').forEach(el => {
			observer.observe(el);
		});
	};
} */

////////////////
// Import our JS
// import './*.js';

///////////////////
// Import Module JS
// import '../../modules/**/*.js';

////////////////////////
// Import Vue Components
// TODO: Auto-import all .vue files and register them using require.context()
/* import ToDo from './todo.vue';

// Init Vue on all [data-vue] elements
document.querySelectorAll('[data-vue]').forEach(el => {
	new Vue({
		el: el,
		components: {
			'todo': ToDo
		}
	});
}); */
