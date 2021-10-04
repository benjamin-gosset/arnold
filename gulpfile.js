const { src, dest, series, watch } = require('gulp'),
  sass = require('gulp-sass'),
  postcss = require("gulp-postcss"),
  autoprefixer = require("autoprefixer"),
  cssnano = require("cssnano"),
  plumber = require('gulp-plumber'),
  browserSync = require('browser-sync'),
  sourcemaps = require('gulp-sourcemaps'),
  svgSymbols = require("gulp-svg-symbols"),
  rename = require("gulp-rename"),
  concat = require("gulp-concat");

const server = browserSync.create();
const url = 'https://arnold.local/';
const paths = {
  styles: {
    src: ["./src/scss/*.scss", "./src/scss/**/*.scss"],
    dest: "./dist/css/"
  },
  scripts: {
    src: ["./src/js/*.js", "./src/js/libs/*.js", "!./src/js/min/*.js"],
    dest: "./dist/js/"
  },
  svg: {
    src: "./src/img/*.svg",
    dest: "./dist/img/"
  },
  php: {
    src: "**/*.php"
  }
};

/* STYLES */
function stylesTask() {
  return src(paths.styles.src[0])
    .pipe(plumber())
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([ autoprefixer("last 2 version"), cssnano() ]))
    .pipe(sourcemaps.write('.'))
    .pipe(rename("main.min.css"))
    .pipe(dest(paths.styles.dest))
    .pipe(server.stream());
}

/* SCRIPTS */
function scriptsTask() {
  return src(paths.scripts.src)
  .pipe(concat("app.js"))
  .pipe(dest(paths.scripts.dest))
  .pipe(server.stream());
}

/* SVG */
function svgTask() {
  return src(paths.svg.src)
  .pipe(
    svgSymbols({
      templates: ["default-svg"],
      svgAttrs: {
        width: 0,
        height: 0,
        display: "none"
      }
    })
  )
  .pipe(rename("sprite.svg.php"))
  .pipe(dest(paths.svg.dest));
}

/* TASKS */ 
function reloadTask(done) {
  server.reload();
  done();
}

function startTask(done) {
  server.init({
    proxy: url,
    open: true,
    ghostMode: false
  });
  done();
}

function watchTask() {
  watch(paths.styles.src, stylesTask);
  watch(paths.php.src, reloadTask);
  watch(paths.scripts.src, scriptsTask);
  watch(paths.svg.src, svgTask);
}

exports.default = series(startTask, watchTask);
