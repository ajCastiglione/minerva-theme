const gulp = require("gulp");
const { src, dest } = require("gulp");
const plumber = require("gulp-plumber");
const sass = require("gulp-sass");
const sassGlob = require("gulp-sass-glob");
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const rename = require("gulp-rename");
const uglify = require("gulp-uglify");
const babel = require("gulp-babel");
const bs = require("browser-sync");

const fs = require("fs");
const path = require("path");
const mergeStream = require("merge-stream");
const concat = require("gulp-concat");
const cssnano = require("gulp-cssnano");
const sourcemaps = require("gulp-sourcemaps");
const gulpif = require("gulp-if");

const env = process.env.NODE_ENV || "development";
const isDevelopment = env === "development";

const componentSrc = path.join(__dirname, "library/blocks");
const componentDist = path.join(__dirname, "library/dist");

const blocks = ["library/blocks/**/*.scss"];

const scss = ["library/scss/*/*.scss", "library/blocks/**/*.scss"];
const imgs = ["library/images/*"];
const all = [
  "library/*.php",
  "*.php",
  "*/*.php",
  "**/**/*.php",
  "library/js/*.js",
  "library/scss/*/*.scss",
  "library/blocks/**/*.scss",
];

const getFolders = (dir) =>
  fs
    .readdirSync(dir)
    .filter((file) => fs.statSync(path.join(dir, file)).isDirectory());

gulp.task("compile-blocks", function () {
  return mergeStream(
    ...getFolders(componentSrc).map((folder) =>
      src(path.join(componentSrc, folder, "*.scss"))
        .pipe(gulpif(isDevelopment, sourcemaps.init()))
        .pipe(sass())
        .pipe(concat(folder + ".css"))
        .pipe(
          postcss([
            autoprefixer({
              browsers: ["last 2 versions"],
              cascade: false,
              grid: true,
            }),
          ])
        )
        .pipe(gulpif(!isDevelopment, cssnano()))
        .pipe(gulpif(isDevelopment, sourcemaps.write(".")))
        .pipe(dest(path.join(componentDist, folder)))
    )
  );
});

//Compile scss
gulp.task("compile", () => {
  return gulp
    .src("./library/scss/style.scss")
    .pipe(sassGlob())
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

// Watch all files for compiling
gulp.task("init", () => {
  bs.init({
    proxy: "mwd.test",
    injectChanges: true,
    files: all,
  });
  gulp.watch(scss, gulp.series("compile", "compile-login"));
  gulp.watch(blocks, gulp.series("compile-blocks"));
});

gulp.task("build", gulp.parallel("compile-blocks", "compile", "compile-login"));

// Start the process
gulp.task("default", gulp.series("init"));
