var gulp = require('gulp');
var plumber = require('gulp-plumber');
var fontello = require('gulp-fontello');
var replace = require('gulp-replace');

module.exports = {
	download: function (file, dest) {
		return gulp.src(file)
			.pipe(fontello())
			.pipe(gulp.dest(dest));
	},

	rewriteCSS: function (src, dest) {
		var afterClass = 'icon--after';

		var baseFind = /\[class\^="icon-"\]:before, \[class\*=" icon-"\]:before/g;
		var baseReplace = '[class^="icon-"]:before, [class*=" icon-"]:before,\n[class^="icon-"]:after, [class*=" icon-"]:after';

		var iconFind = /\.icon-(.*?):before {(.*?)}/g;
		var iconReplace = '.icon-$1:before {$2}\n.icon-$1.' + afterClass + ':before {content: normal}\n.icon-$1.' + afterClass + ':after {$2}';

		var pathFind = /\.\.\/font\/fontello/g;
		var pathReplace = 'icons/font/fontello';

		return gulp.src(src + 'css/fontello.css')
			.pipe(replace(baseFind, baseReplace))
			.pipe(replace(iconFind, iconReplace))
			.pipe(replace(pathFind, pathReplace))
			.pipe(gulp.dest(dest));
	}
};
