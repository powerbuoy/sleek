// Insert all example code into the page so we can actually see the examples
//window.addEventListener('load', function () {
    var elements = document.querySelectorAll('.styleguide__element');

    for (var i = 0; i < elements.length; i++) {
        (function () {
            var element = elements[i];
            var exampleCode = element.querySelector('.styleguide__example-code');
            var example = element.querySelector('.styleguide__example');

            if (exampleCode) {
                example.innerHTML = exampleCode.textContent;
            }
        })();
    }
//});
