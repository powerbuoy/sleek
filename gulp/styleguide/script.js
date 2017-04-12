// Insert all example code into the page so we can actually see the examples
//window.addEventListener('load', function () {
	var elements = document.querySelectorAll('.styleguide-component');

	for (var i = 0; i < elements.length; i++) {
		(function () {
			var element = elements[i];
			var example = element.querySelector('.styleguide-component-example');
			var exampleCode = element.querySelector('.styleguide-component-code-block');

			if (exampleCode) {
				example.innerHTML = exampleCode.textContent;
			}
		})();
	}
//});
