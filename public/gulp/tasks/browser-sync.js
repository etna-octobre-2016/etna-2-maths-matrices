var gulp        = require('gulp');
var browserSync = require('browser-sync');

gulp.task('browser-sync', function(){

    browserSync({
        server: {
            baseDir: "./src"
        }
    });

    // used by the "sass" task
    global.browserSyncReload = browserSync.reload;
});
