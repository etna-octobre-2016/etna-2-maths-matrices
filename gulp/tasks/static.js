var config = require("../config.json");
var gulp   = require("gulp");

gulp.task("static", function()
{
    return gulp.src(config.static.paths, {base: config.paths.src}).pipe(gulp.dest(config.paths.dist));
});
