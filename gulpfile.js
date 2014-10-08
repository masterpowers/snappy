var gulp = require('gulp'),
    concat = require('gulp-concat'),
    minifyCss = require('gulp-minify-css');

gulp.task('deploy', function() {
  gulp.src([
    'public/assets/css/base/reset.css',
    'public/assets/css/base/base.css',
    'public/assets/css/base/form.css',
    'public/assets/css/modules/*.css',
    'public/assets/css/layout/*.css'
  ])
    .pipe(concat('bundle.css'))
    .pipe(minifyCss({ keepBreaks: true }))
    .pipe(gulp.dest('public/assets/css/dist/'));

  gulp.src([
    'public/assets/js/modules/auth/module.js',
    'public/assets/js/modules/auth/factory.js',
    'public/assets/js/modules/auth/service.js',
    'public/assets/js/modules/auth/controller.js',
    'public/assets/js/modules/contacts/module.js',
    'public/assets/js/modules/contacts/factory.js',
    'public/assets/js/modules/contacts/controller/js',
    'public/assets/js/modules/chats/module.js',
    'public/assets/js/modules/chats/factory.js',
    'public/assets/js/modules/chats/controller.js',
    'public/assets/js/vendor/webcam.js',
    'public/assets/js/application.js'
  ])
    .pipe(concat('bundle.js'))
    .pipe(gulp.dest('public/assets/js/dist/'));
});