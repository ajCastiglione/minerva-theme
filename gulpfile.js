const gulp = require("gulp");
const { src, dest } = require("gulp");
const plumber = require("gulp-plumber");
const sass = require("gulp-sass");
const sassGlob = require("gulp-sass-glob");
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const rename = require("gulp-rename");
const uglify = require("gulp-uglify");
const webpack = require("webpack-stream");
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

const componentSrc = path.join(__dirname, "blocks");
const componentDist = path.join(__dirname, "library/dist");

const blocks_scss = ["blocks/**/*.scss"];
const blocks_js = ["blocks/**/*.js"];
const editor = ["library/scss/editor-style.scss"];
const scss = ["library/scss/*/*.scss", "library/blocks/**/*.scss"];
const js = ["library/js/scripts.js"];
const imgs = ["library/images/*"];
const all = [
  "library/*.php",
  "*.php",
  "*/*.php",
  "**/**/*.php",
  "library/js/**/*.js",
];

const getFolders = (dir) =>
  fs
    .readdirSync(dir)
    .filter((file) => fs.statSync(path.join(dir, file)).isDirectory());

gulp.task("compile-blocks-styles", function () {
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
        .pipe(bs.stream())
    )
  );
});

gulp.task("compile-blocks-js", function () {
  return mergeStream(
    ...getFolders(componentSrc).map((folder) =>
      src(path.join(componentSrc, folder, "*.js"))
        .pipe(
          webpack({
            mode: "production",
            output: {
              filename: folder + ".js",
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
        .pipe(concat(folder + ".js"))
        .pipe(gulpif(!isDevelopment, uglify()))
        .pipe(rename({ extname: ".min.js" }))
        .pipe(gulpif(isDevelopment, sourcemaps.write(".")))
        .pipe(dest(path.join(componentDist, folder)))
        .pipe(bs.stream())
    )
  );
});

// Compile JS
gulp.task("scripts", () => {
  return gulp
    .src(js)
    .pipe(
      webpack({
        mode: "production",
        output: {
          filename: "scripts.js",
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
    .pipe(gulp.dest("./library/js/dist"));
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

gulp.task("compile-editor", () => {
  return gulp
    .src("./library/scss/editor-style.scss")
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
    proxy: "mwdbasetheme.test",
    injectChanges: true,
    files: all,
  });
  gulp.watch(scss, gulp.series("compile", "compile-login"));
  gulp.watch(js, gulp.series("scripts"));
  gulp.watch(blocks_scss, gulp.series("compile-blocks-styles"));
  gulp.watch(blocks_js, gulp.series("compile-blocks-js"));
  gulp.watch(editor, gulp.series("compile-editor"));
});

gulp.task(
  "build",
  gulp.series(
    "compile-blocks-styles",
    "compile-blocks-js",
    "compile",
    "scripts",
    "compile-login",
    "compile-editor"
  )
);

// Start the process
gulp.task("default", gulp.series("init"));
