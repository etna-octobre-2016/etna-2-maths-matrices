var gulp = require('gulp');

gulp.task('default', ['browser-sync', 'browserify', 'sass'], function(){

    gulp.watch('src/**/*.scss', ['sass']);
    gulp.watch(['src/**/*.html', 'src/**/*.ejs'], ['browser-sync-reload']);
    gulp.watch('src/js/modules/**/*.js', ['browserify']);
});
