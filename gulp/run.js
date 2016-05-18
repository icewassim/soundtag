"use strict";

let gulp = require('gulp'),
		nodemon = require('gulp-nodemon'),
		express = require('express');


gulp.task('run-server', function() {
  return nodemon({
    script: './src/server.js',
    ext: 'js',
    execMap: {
      js: "node --harmony --use_strict"
    },
    ignore: ['node_modules/**', '.git', 'build/*'],
  });
});
