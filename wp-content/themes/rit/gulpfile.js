const gulp = require('gulp');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const watch = require('gulp-watch');

// Define a task to minify JavaScript files
gulp.task('minify-js', function() {
	return gulp.src('js/*.js') // Source folder containing the JavaScript files
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('dest/js/')); // Destination folder for minified files
});

// Define a task to watch for changes in JavaScript files
gulp.task('watch-js', function() {
	gulp.watch('js/*.js', gulp.series('minify-js'));
});

// Default task
gulp.task('default', gulp.series('minify-js', 'watch-js'));
