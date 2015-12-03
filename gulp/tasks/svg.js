var argv      = require("../modules/argv");
var config    = require("../config.json");
var gulp      = require("gulp");
var svgSprite = require("gulp-svg-sprite");

gulp.task("svg", function(){

    var source      = config.paths.src + "/assets/icons/*.svg";
    var destination = (argv.env === "development") ? config.paths.tmp + "/assets/icons" : config.paths.dist + "/assets/icons";

    return gulp
        .src(source)
        .pipe(svgSprite(config.svgSprite))
        .pipe(gulp.dest(destination));
});
