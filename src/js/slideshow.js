import Glide from '@glidejs/glide';

//////////////////////////
// Modify the active class
var VisibleClass = function (Glide, Components, Events) {
	var Component = {
		mount () {
			this.setVisibleClasses();
		},

		setVisibleClasses () {
			if (Glide.settings.perView > 1) {
				const glideEl = Components.Html.root;
				const active = Components.Html.slides[Glide.index];

				// Calculate how many on each side we need to add visible classes to
				if (Glide.settings.focusAt === 'center') {
					var numBefore = Math.ceil((Glide.settings.perView - 1) / 2);
					var numAfter = numBefore;
				}
				else {
					var numBefore = Glide.settings.focusAt;
					var numAfter = Glide.settings.perView - Glide.settings.focusAt - 1;
				}

				// Remove visible classes
				glideEl.querySelectorAll('.glide__slide--visible').forEach(slide => {
					slide.classList.remove('glide__slide--visible');
				});

				// Add visible class to active slide
				active.classList.add('glide__slide--visible');

				// Add visible classes to next siblings
				var next = active.nextElementSibling;

				if (next) {
					next.classList.add('glide__slide--visible');

					for (let i = 0; i < numAfter - 1; i++) {
						if (next && (next = next.nextElementSibling)) {
							next.classList.add('glide__slide--visible');
						}
					}
				}

				// Add visible classes to previous siblings
				var prev = active.previousElementSibling;

				if (prev) {
					prev.classList.add('glide__slide--visible');

					for (let i = 0; i < numBefore - 1; i++) {
						prev = prev.previousElementSibling;

						if (prev) {
							prev.classList.add('glide__slide--visible');
						}
					}
				}
			}
			else {
				Components.Html.root.querySelectorAll('.glide__slide--visible').forEach(slide => {
					slide.classList.remove('glide__slide--visible');
				});
				Components.Html.slides[Glide.index].classList.add('glide__slide--visible');
			}
		}
	};

	Events.on('run', () => {
		Component.setVisibleClasses();
	});

	return Component;
};

////////////////////////////////////
// Go through every [data-slideshow]
document.querySelectorAll('[data-slideshow]').forEach(el => {
	// Make sure we have some slides
	if (el.children.length) {
		/////////////////////////
		// Use --grid-gap for gap
		var gap = (parseFloat(window.getComputedStyle(el).getPropertyValue('--grid-gap')) * 16);

		gap = isNaN(gap) ? 32 : gap;

		////////////////
		// Create config
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

		const config = Object.assign({
			type: 'carousel',
			perView: 1,
			focusAt: 'center',
			gap: gap,
			animationDuration: 800,
			autoplay: 6000
		}, args);

		// Make sure we're not trying to focus outside of page
		if (config.focusAt !== 'center' && config.focusAt > (config.perView - 1)) {
			config.focusAt = config.perView - 1;
		}

		////////////////
		// Create markup
		el.classList.add('glide');

		const trackEl = document.createElement('div');
		const slidesEl = document.createElement('div');

		trackEl.classList.add('glide__track');
		trackEl.setAttribute('data-glide-el', 'track');
		slidesEl.classList.add('glide__slides');

		// Create prev/next buttons
		const buttons = document.createElement('div');

		buttons.classList.add('slideshow-nav');
		buttons.setAttribute('data-glide-el', 'controls');
		buttons.innerHTML = '<a data-glide-dir="<" class="slideshow-prev">&larr;</a><a data-glide-dir=">" class="slideshow-next">&rarr;</a>';

		// Create bullets
		const nav = document.createElement('div');

		nav.classList.add('slideshow-bullets');
		nav.setAttribute('data-glide-el', 'controls[nav]');

		let bullets = '';

		// Add classes to existing markup
		[...el.children].forEach((child, index) => {
			bullets += '<a data-glide-dir="=' + index + '">' + (index + 1) + '</a>'

			child.classList.add('glide__slide');
			slidesEl.appendChild(child);
		});

		nav.innerHTML = bullets;

		/////////////////////////////////
		// Now move everything into place
		trackEl.appendChild(slidesEl);
		el.appendChild(trackEl);
		el.appendChild(buttons);
		el.appendChild(nav);

		////////////////
		// Create slider
		el.glidejs = new Glide(el, config);

		// HACK: Allow other code to add events to el.glidejs before mounting
		setTimeout(() => {
			el.glidejs.mount({
			//	VisibleClass // NOTE: Use if needed
			});
		});
	}
});
