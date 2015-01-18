var browserify  = require('browserify'),
    gulp        = require('gulp'),
    gutil       = require('gulp-util'),
    source      = require('vinyl-source-stream');

gulp.task('browserify', function(){

    return browserify('./src/js/modules/index.js')
        .transform('browserify-shim')
        .bundle()
        .on('error', gutil.log)
        .pipe(source('main.js'))
        .pipe(gulp.dest('src/js'))
        .pipe(global.browserSyncReload({ stream:true }));
});
