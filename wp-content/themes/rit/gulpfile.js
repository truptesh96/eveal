const gulp = require('gulp');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const sass = require('gulp-sass')(require('sass')); // Corrected SASS processor

// Task to minify JS files
gulp.task('minify-js', function() {
    return gulp.src('js/*.js') // Source folder
        .pipe(uglify())
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('dest/js/')); // Destination folder
});

// Watch for changes in JS files
gulp.task('watch-js', function() {
    gulp.watch('js/*.js', gulp.series('minify-js'));
});

// Task to compile and minify SASS files
gulp.task('minify-sass', function() {
    return gulp.src('sass/*.scss') // Source folder
        .pipe(sass({style: 'compressed'}).on('error', sass.logError))
        .pipe(rename({ suffix: '.min' }))
        .pipe(gulp.dest('dest/css/')); // Destination folder
});

// Watch for changes in SASS files
gulp.task('watch-sass', function() {
    gulp.watch('sass/**/*.scss', gulp.series('minify-sass'));
});

// Default task
gulp.task('default', gulp.parallel('watch-sass', 'watch-js', 'minify-sass', 'minify-js'));
