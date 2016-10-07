var gulp = require('gulp');
var fontello = require('gulp-fontello');
var replace = require('gulp-replace');
var rename = require('gulp-rename');

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
			.pipe(rename('icons.scss'))
			.pipe(gulp.dest(dest));
	},

	generateIconVars: function (src, dest) {
		var find = /\.icon-(.*?):before \{ content: '(.*?)'; \} \/\*.*?\*\//g;
		var rep = '\$icon-$1: "$2";';

		return gulp.src(src + 'css/fontello-codes.css')
			.pipe(replace(find, rep))
			.pipe(rename('icon-vars.scss'))
			.pipe(gulp.dest(dest));
	}
};
