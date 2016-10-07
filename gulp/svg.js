var gulp = require('gulp');
var globby = require('globby');
var rename = require('gulp-rename');
var svgstore = require('gulp-svgstore');
var svgmin = require('gulp-svgmin');
var path = require('path');

module.exports = {
	min: function (src, dest) {
		return gulp.src(src)
		   .pipe(svgmin(function (file) {
			   var prefix = 'svg-' + path.basename(file.relative, path.extname(file.relative));

			   return {
					plugins: [{
						cleanupIDs: {
							prefix: prefix + '-',
							minify: true
						}
					}]
				};
			}))
			.pipe(gulp.dest(dest));
	},

	store: function (src, dest) {
		return gulp
			.src(src)
			.pipe(svgmin(function (file) {
				var prefix = 'svg-' + path.basename(file.relative, path.extname(file.relative));

				return {
					plugins: [{
						cleanupIDs: {
							prefix: prefix + '-',
							minify: true
						}
					}]
				};
			}))
			.pipe(svgstore())
			.pipe(rename('svg-defs.svg'))
			.pipe(gulp.dest(dest));
	},

	css: function (src, dest) {
		var css = '';

		globby.sync(src).forEach(function (file) {
			var basename = path.basename(file);
			var className = 'svg-' + basename.substr(0, basename.length - path.extname(file).length);
			var paths = file.split('/');

			paths.shift();

			css += '.' + className + ':before {background-image: url(' + paths.join('/') + ')}\n';
		});

		return require('fs').writeFileSync(dest, css);
	}
};
