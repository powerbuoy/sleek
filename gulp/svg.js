var gulp = require('gulp');
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
	}
};
