const gulp = require("gulp");
const plumber = require("gulp-plumber");
const sass = require("gulp-sass");
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const image = require("gulp-image");
const bs = require("browser-sync");
const rename = require("gulp-rename");
const uglify = require("gulp-uglify");
const babel = require("gulp-babel");

const scss = ["library/scss/*/*.scss"];
const imgs = ["library/images/*"];
const js = "library/js/scripts.js";
const all = ["library/*.php", "*.php", "*/*.php", "library/js/*.js"];

// Compile and minify JS + babel
gulp.task("js", function () {
    return gulp
        .src(js)
        .pipe(
            babel({
                presets: ["@babel/preset-env"],
            })
        )
        .pipe(
            rename({
                extname: ".min.js",
            })
        )
        .pipe(uglify())
        .pipe(gulp.dest("library/js"));
});

//Compile scss
gulp.task("compile", () => {
    return gulp
        .src("./library/scss/*.scss")
        .pipe(plumber())
        .pipe(
            sass({
                outputStyle: "compressed",
            }).on("error", sass.logError)
        )
        .pipe(
            postcss([
                autoprefixer({
                    browsers: ["last 2 versions"],
                    cascade: false,
                    grid: true,
                }),
            ])
        )
        .pipe(gulp.dest("./library/css"))
        .pipe(bs.stream());
});

gulp.task("compile-login", () => {
    return gulp
        .src("./library/scss/modules/login.scss")
        .pipe(plumber())
        .pipe(
            sass({
                outputStyle: "compressed",
            }).on("error", sass.logError)
        )
        .pipe(
            postcss([
                autoprefixer({
                    browsers: ["last 2 versions"],
                    cascade: false,
                }),
            ])
        )
        .pipe(gulp.dest("./library/css"));
});

// Compress images and return them to folder
gulp.task("min-images", () => {
    gulp.src(imgs).pipe(image()).pipe(gulp.dest("./library/images"));
});

// Watch all files for compiling
gulp.task("init", () => {
    bs.init({
        proxy: "mwdbaseline.test",
        injectChanges: true,
        files: all,
    });
    gulp.watch(scss, gulp.series("compile", "compile-login"));
    gulp.watch(js, gulp.series("js"));
});

// Start the process
gulp.task("default", gulp.series("init"));
