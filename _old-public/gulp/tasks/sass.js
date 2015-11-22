var gulp        = require('gulp'),
    sass        = require('gulp-sass'),
    sassConfig  = { errLogToConsole: true, outputStyle: 'compressed' };

gulp.task('sass', ['sass_main', 'sass_components']);

gulp.task('sass_components', function(){

    return gulp
        .src(['./src/html/components/**/*.scss'], {base: '.'})
        .pipe(sass(sassConfig))
        .pipe(gulp.dest('.'))
        .pipe(global.browserSyncReload({ stream:true }));
});

gulp.task('sass_main', function(){

    return gulp
        .src(['./src/sass/*.scss'])
        .pipe(sass(sassConfig))
        .pipe(gulp.dest('./src/css'))
        .pipe(global.browserSyncReload({ stream:true }));
});
