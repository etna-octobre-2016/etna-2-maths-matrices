var argv      = require("../modules/argv"),
    config    = require("../config.json"),
    gulp      = require("gulp"),
    notifier  = require("node-notifier"),
    path      = require("path"),
    replace   = require("gulp-replace"),
    sass      = require("gulp-sass");

function onSassError(callback, err)
{
    notifier.notify({
        icon: path.normalize(__dirname + "/../assets/img/sass.png"),
        title: "Sass",
        message: err.message,
        sound: true
    });
    console.error(err.message);
    callback();
}

gulp.task("sass", function(callback)
{
    var destination;
    var sassConfig;
    var source = config.paths.src + "/sass/*.scss";

    if (argv.env === "production" || argv.env === "preprod")
    {
        sassConfig = config.sass.dist;
        destination = config.paths.dist + "/css";
    }
    else
    {
        sassConfig = config.sass.dev;
        destination = config.paths.tmp + "/css";
    }
    return gulp.src(source)
        .pipe(sass(sassConfig))
        .on("error", onSassError.bind(null, callback))
        .pipe(replace("../../assets", "../assets"))
        .pipe(gulp.dest(destination));
});
