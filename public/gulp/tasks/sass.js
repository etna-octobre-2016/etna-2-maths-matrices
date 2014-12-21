var gulp        = require('gulp'),
    sass        = require('gulp-sass'),
    sassConfig  = { errLogToConsole: true };

gulp.task('sass', ['sass_main', 'sass_components']);

gulp.task('sass_components', function(){

    return gulp
        .src(['./src/components/**/*.scss'], {base: '.'})
        .pipe(sass(sassConfig))
        .pipe(gulp.dest('.'));
});

gulp.task('sass_main', function(){

    return gulp
        .src(['src/sass/*.scss'])
        .pipe(sass(sassConfig))
        .pipe(gulp.dest('dist/css'));
});
