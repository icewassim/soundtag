'use strict';

let gulp = require('gulp'),
  tsc = require('gulp-typescript'),
  conf = require('./conf'),
  sourcemaps = require('gulp-sourcemaps'),
  wrench = require('wrench'),
  del = require('del'),
  concat = require('gulp-concat'),
  tslint = require('gulp-tslint');


gulp.task('ts-compile', function() {
  let tsResult = gulp.src(conf.paths.appTsFilesPath)
    .pipe(sourcemaps.init())
    .pipe(tsc({
      target: 'ES5',
      sortOutput: true,
      module: "amd",
      preserveConstEnums: true,
    }));

  return tsResult.js
		.pipe(concat(conf.paths.distCoreJS))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(conf.paths.dist));

});

gulp.task('ts-lint', function() {
  return gulp.src(conf.paths.appTsFilesPath)
						  .pipe(tslint())
							.pipe(tslint.report('prose'));
});

gulp.task('ts-clean', function() {
  return del(['dist/**/*']);
});

gulp.task('build', ['ts-clean', 'ts-lint', 'ts-compile']);
