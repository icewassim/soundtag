'use strict';

var gulp = require('gulp'),
    conf = require('./conf'),
    concat = require('gulp-concat'),
    sass = require('gulp-sass');

gulp.task('sass', function () {
  return gulp.src(conf.paths.appSassFilesPath)
    .pipe(sass().on('error', sass.logError))
    .pipe(concat(conf.paths.distIndexCss))
    .pipe(gulp.dest(conf.paths.dist));
});
