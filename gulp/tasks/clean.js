var argv   = require("../modules/argv");
var config = require("../config.json");
var del    = require("del");
var gulp   = require("gulp");

gulp.task("clean", function(callback)
{
    var paths = {
        development: [
            config.paths.tmp
        ],
        preprod: [
            config.paths.dist
        ],
        production: [
            config.paths.dist
        ]
    };
    var options = {force: true};

    del(paths[argv.env], options, function(err, paths)
    {
        if (err)
        {
            throw err;
        }
        callback();
    });
});
