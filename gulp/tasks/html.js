var argv    = require("../modules/argv");
var config  = require("../config.json");
var gulp    = require("gulp");
var replace = require("gulp-replace");

gulp.task("html", function(callback)
{
    var source = [
        config.paths.src + "/components/**/*.html",
        config.paths.src + "/*.html",
        config.paths.src + "/sections/**/*.html"
    ];
    gulp.src(source, {base: config.paths.src}).pipe(gulp.dest(config.paths.buffer));
    callback();
});
