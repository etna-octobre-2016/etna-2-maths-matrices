var gulp = require('gulp'),
    sass = require('gulp-sass');

var sassConfig = {
    errLogToConsole: true
};

gulp.task('sass', function(){

    gulp.src('src/sass/*.scss')
        .pipe(sass(sassConfig))
        .pipe(gulp.dest('dist/css'));
});
