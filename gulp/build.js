'use strict';

let gulp = require('gulp'),
	tsc = require('gulp-typescript'),
	conf = require('./conf'),
	sourcemaps = require('gulp-sourcemaps'),
	tslint = require('gulp-tslint');


gulp.task('ts-compile',function(){
   	let tsResult = gulp.src(conf.paths.appTsFilesPath)
    					.pipe(sourcemaps.init())
                       .pipe(tsc({
                           target: 'ES5',
                           declarationFiles: false,
                           noExternalResolve: true
                       }));

    tsResult.dts.pipe(gulp.dest("./dest"));
    return tsResult.js
                   .pipe(sourcemaps.write('.'))
                   .pipe(gulp.dest(conf.paths.dist));

});

gulp.task('ts-lint', function () {
	return gulp.src('./src/app/**/*.ts').pipe(tslint()).pipe(tslint.report('prose'));
});

gulp.task('build',['ts-lint','ts-compile']);