var gulp        = require('gulp'),
    sass        = require('gulp-sass'),
    sassConfig  = { errLogToConsole: true };

gulp.task('sass', ['sass_components']);

gulp.task('sass_components', function(){

    return gulp.src(['./src/components/**/*.scss'], {base: '.'})
        .pipe(sass(sassConfig))
        .pipe(gulp.dest('.'));
});
