var gulp        = require('gulp'),
    sass        = require('gulp-sass'),
    sassConfig  = { errLogToConsole: true };

gulp.task('sass', function(){

    return gulp.src('src/sass/*.scss')
        .pipe(sass(sassConfig))
        .pipe(gulp.dest('dist/css'))
        .pipe(global.browserSyncReload({ stream:true }));
});
