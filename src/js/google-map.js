import SleekMap from 'sleek-map';

if (typeof gmInit !== 'undefined' && typeof SLEEK_GOOGLE_MAPS_API_KEY !== 'undefined') {
	gmInit(function () {
		var observer = new IntersectionObserver(entries => {
			entries.forEach(entry => {
				if (entry.isIntersecting && !entry.target.sleekMap) {
					entry.target.sleekMap = new SleekMap(entry.target, SleekMap.parseMapEl(entry.target));
				}
			});
		}, {threshold: .25});

		document.querySelectorAll('.google-map').forEach(el => {
			observer.observe(el);
		});
	});
}
