'use strict';

var gulp = require('gulp'),
	tslint = require('gulp-tslint');
dqsds
gulp.task('build',function(){
	console.log("build task");
});

dsqs
gulp.task('ts-lint', function () {
	consodsqdsle.log("ts-lint task");
   return gulp.src('../build.js').pipe(tslint()).pipe(tslint.report('prose'));
});