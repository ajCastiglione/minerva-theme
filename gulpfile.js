const gulp = require("gulp");
const plumber = require("gulp-plumber");
const sass = require("gulp-sass");
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const image = require("gulp-image");
const bs = require("browser-sync");

const scss = ["library/scss/*/*.scss"];
const imgs = ["library/images/*"];
const all = ["library/*.php", "*.php", "*/*.php", "library/js/*.js"];

//Compile scss
gulp.task("compile", () => {
  return gulp
    .src("./library/scss/*.scss")
    .pipe(plumber())
    .pipe(
      sass({
        outputStyle: "compressed"
      }).on("error", sass.logError)
    )
    .pipe(
      postcss([
        autoprefixer({
          browsers: ["last 2 versions"],
          cascade: false
        })
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
        outputStyle: "compressed"
      }).on("error", sass.logError)
    )
    .pipe(
      postcss([
        autoprefixer({
          browsers: ["last 2 versions"],
          cascade: false
        })
      ])
    )
    .pipe(gulp.dest("./library/css"));
});

// Compress images and return them to folder
gulp.task("min-images", () => {
  gulp
    .src("./library/images/*")
    .pipe(image())
    .pipe(gulp.dest("./library/images"));
});

// Watch all files for compiling
gulp.task("watch-scss", ["compile", "compile-login", "min-images"], () => {
  bs.init({
    proxy: "https://minervatheme.local",
    injectChanges: true,
    files: all
  });
  gulp.watch(scss, ["compile", "compile-login"]);
});

// Start the process
gulp.task("default", ["watch-scss"]);
