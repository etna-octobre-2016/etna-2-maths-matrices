var gulp = require('gulp');

gulp.task('default', ['clean', 'browser-sync', 'sass'], function(){
    gulp.watch('src/sass/*.scss', ['sass']);
    gulp.watch(['*.html', 'src/html/**/*.html'], ['browser-sync-reload']);
});
