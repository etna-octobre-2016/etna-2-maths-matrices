var gulp = require('gulp');

gulp.task('default', ['browserify', 'browser-sync', 'sass'], function(){

    // Page reload on SASS files edit
    gulp.watch('src/**/*.scss', ['sass', 'browser-sync-reload']);

    // Page reload on HTML files edit
    gulp.watch(['*.html', 'src/**/*.html'], ['browser-sync-reload']);

    // Page reload on Javascript files edit
    gulp.watch(['src/js/**/*.js'], ['browserify', 'browser-sync-reload']);
});
