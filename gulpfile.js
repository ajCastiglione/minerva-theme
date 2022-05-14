const gulp = require("gulp");
const plumber = require("gulp-plumber");
const sass = require("gulp-sass");
const cssnano = require("cssnano");
const sassGlob = require("gulp-sass-glob");
const mmq = require("gulp-merge-media-queries");
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const rename = require("gulp-rename");
const uglify = require("gulp-uglify");
const webpack = require("webpack-stream");
const bs = require("browser-sync");

const path = require("path");
const sourcemaps = require("gulp-sourcemaps");
const gulpif = require("gulp-if");

const env = process.env.NODE_ENV || "development";
const isDevelopment = env === "development";

const config = {
  bs: {
    proxy: "http://mwdbasetheme.test/",
  },
  sassEntry: {
    src: "./library/scss/style.scss",
    dist: path.join(__dirname, "library/css"),
  },
  js: {
    src: "./library/js/scripts.js",
    dest: path.join(__dirname, "library/dist"),
  },
  filesToWatch: {
    js: ["library/js/**/*.js", "!/dist/js/*.js"],
    sass: ["scss/*.scss", "scss/**/*.scss", "scss/**/**/*.scss", "scss/**/**/**/*.scss"],
    global: ["library/*.php", "*.php", "*/*.php", "**/**/*.php", "library/js/**/*.js"],
  },
};

// Compile JS
gulp.task("scripts", () => {
  return gulp
    .src(config.js.src)
    .pipe(
      webpack({
        mode: "production",
        output: {
          filename: "master.js",
        },
        module: {
          rules: [
            {
              test: /\.(js|jsx)$/,
              use: ["babel-loader"],
              exclude: /node_modules/,
            },
          ],
        },
      })
    )
    .pipe(gulpif(isDevelopment, sourcemaps.init()))
    .pipe(gulpif(!isDevelopment, uglify()))
    .pipe(rename({ extname: ".min.js" }))
    .pipe(gulpif(isDevelopment, sourcemaps.write(".")))
    .pipe(gulp.dest(config.js.dest))
    .pipe(bs.stream());
});

//Compile scss
gulp.task("sass", () => {
  return gulp
    .src(config.sassEntry.src)
    .pipe(sassGlob())
    .pipe(plumber())
    .pipe(sass().on("error", sass.logError))
    .pipe(
      mmq({
        log: true,
      })
    )
    .pipe(
      postcss([
        cssnano(),
        autoprefixer({
          browsers: ["last 2 versions"],
          cascade: false,
          grid: true,
        }),
      ])
    )
    .pipe(gulp.dest(config.sassEntry.dist))
    .pipe(bs.stream());
});

// Watch all files for compiling
gulp.task("init", () => {
  bs.init({
    proxy: config.bs.proxy,
    injectChanges: true,
    files: config.filesToWatch.global,
  });
  gulp.watch(config.filesToWatch.sass, gulp.series("sass"));
  gulp.watch(config.filesToWatch.js, gulp.series("scripts"));
});

gulp.task("build", gulp.series("sass", "scripts"));

// Start the process
gulp.task("default", gulp.series("build", "init"));
