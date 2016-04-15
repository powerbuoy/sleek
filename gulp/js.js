var gulp = require('gulp');
var sourcemaps = require('gulp-sourcemaps');
var uglify = require('gulp-uglify');
var through = require('through2');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var gutil = require('gulp-util');
var globby = require('globby');
var browserify = require('browserify');

module.exports = function (src, dest) {
	// gulp expects tasks to return a stream, so we create one here.
	var bundledStream = through();

	bundledStream
		// turns the output bundle stream into a stream containing
		// the normal attributes gulp plugins expect.
		.pipe(source('all.js'))

		// the rest of the gulp task, as you would normally write it.
		// here we're copying from the Browserify + Uglify2 recipe.
		.pipe(buffer())
		.pipe(sourcemaps.init({loadMaps: true}))

		// Add gulp plugins to the pipeline here.
		.pipe(uglify())
		.on('error', gutil.log)
		.pipe(sourcemaps.write('./'))
		.pipe(gulp.dest(dest));

		// "globby" replaces the normal "gulp.src" as Browserify
		// creates it's own readable stream.
		globby([src + '*.js']).then(function (entries) {
			// create the Browserify instance.
			var b = browserify({
				entries: entries,
				debug: true
			})
			.transform({global: true}, 'browserify-shim');

			// pipe the Browserify stream into the stream we created earlier
			// this starts our gulp pipeline.
			b.bundle().pipe(bundledStream);
		})
		.catch(function(err) {
			// ensure any errors from globby are handled
			bundledStream.emit('error', err);
		});

	// finally, we return the stream, so gulp knows when this task is done.
	return bundledStream;
};
