// Insert all example code into the page so we can actually see the examples
//window.addEventListener('load', function () {
	var elements = document.querySelectorAll('section article');

	for (var i = 0; i < elements.length; i++) {
		(function () {
			var element = elements[i];
			var exampleCode = element.querySelector('.example-code');
			var example = element.querySelector('.example');

			if (exampleCode) {
				example.innerHTML = exampleCode.textContent;
			}
		})();
	}
//});
