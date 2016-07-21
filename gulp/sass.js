var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var sassGlob = require('gulp-sass-glob');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var minifyCSS = require('gulp-minify-css');

module.exports = function (file, dest) {
	return gulp.src(file)
		.pipe(plumber({
			errorHandler: function (err) {
				console.log(err);
				this.emit('end');
			}
		}))
		.pipe(sourcemaps.init())
		.pipe(sassGlob())
		.pipe(sass())
		.pipe(autoprefixer({
			browsers: ['last 1 version', 'IE 9', 'IE 10', '> 2%']
		}))
		.pipe(minifyCSS({
			advanced: false
		}))
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(dest));
};
