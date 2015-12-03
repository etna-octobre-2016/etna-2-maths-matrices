var browserSync = require('browser-sync');
var config      = require('../config.json');
var fs          = require('fs');
var gulp        = require('gulp');

gulp.task('browser-sync', function(){
    if (!fs.existsSync(config.paths.tmp)) // @note: creates tmp/ dir if doesn't exist
    {
        fs.mkdirSync(config.paths.tmp);
    }
    browserSync(config.browserSync);
    global.browserSyncReload = browserSync.reload; // @note: used by other tasks on file modifications
});
