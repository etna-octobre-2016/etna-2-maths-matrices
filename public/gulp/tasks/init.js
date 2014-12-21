var gulp = require('gulp');

gulp.task('default', ['clean', 'browser-sync', 'sass'], function(){
    gulp.watch('src/**/*.scss', ['sass', 'browser-sync-reload']);
    gulp.watch(['*.html', 'src/**/*.html'], ['browser-sync-reload']);
});
