var LiveFilter = {
	init: function (tags, items) {
		var self = this;

		for (var i = 0; i < tags.length; i++) {
			tags[i].addEventListener('click', function (e) {
				e.preventDefault();
				this.classList.toggle('active');

				self.update(tags, items);
			});
		}
	}, 

	update: function (tags, items) {
		var selectedTags = [];

		for (var i = 0; i < tags.length; i++) {
			if (tags[i].classList.contains('active')) {
				selectedTags.push(tags[i].innerHTML);
			}
		}

		for (var i = 0; i < items.length; i++) {
			var hidden = false;

			for (var j = 0; j < selectedTags.length; j++) {
				if (!items[i].classList.contains(selectedTags[j].trim())) {
					hidden = true;
				}
			}

			if (hidden) {
				items[i].classList.add('hidden');
			}
			else {
				items[i].classList.remove('hidden');
			}
		}
	}
};
