var gulp = require('gulp'),
    gulpLoadPlugins = require('gulp-load-plugins'),
    plugins = gulpLoadPlugins(),

    less = require('gulp-less');

var app = 'app/Resources';

var onError = function(err) {
    console.log(err);
};

gulp.task('less', function() {
    gulp.src(app + '/less/**/*.less')
        .pipe(plugins.plumber({
            errorHandler: onError
        }))
        .pipe(less())
        .pipe(plugins.minifyCss({keepSpecialComments:0}))
        .pipe(plugins.rename({suffix: '.min'}))
        .pipe(gulp.dest('web/css/'));
});

gulp.task('copy', function() {
    gulp.src([
        app + '/fonts/*.{ttf,woff,woff2,eof,svg,eot}',
        app + '/libs/bootstrap-material-design/fonts/*.{ttf,woff,woff2,eof,svg,eot}',
        app + '/libs/components-font-awesome/fonts/*.{ttf,woff,woff2,eof,svg,eot}'
    ])
        .pipe(gulp.dest('web/fonts/'));

    gulp.src([
        app + '/libs/bootstrap/dist/css/bootstrap.css',
        app + '/libs/bootstrap-material-design/dist/css/material.css',
        app + '/libs/bootstrap-material-design/dist/css/ripples.css',
        app + '/libs/bootstrap-material-design/dist/css/roboto.css',
        app + '/libs/components-font-awesome/css/font-awesome.css'
    ])
        .pipe(plugins.concat('app.css'))
        .pipe(gulp.dest('web/css/'))
        .pipe(plugins.minifyCss({keepSpecialComments:0}))
        .pipe(plugins.rename({suffix: '.min'}))
        .pipe(gulp.dest('web/css/'));
});

gulp.task('concat', function() {
    gulp.src([
        app + '/libs/jquery/dist/jquery.js',
        app + '/libs/bootstrap/dist/js/bootstrap.js',
        app + '/libs/bootstrap-material-design/dist/js/material.js',
        app + '/libs/bootstrap-material-design/dist/js/riples.js'
    ])
        .pipe(plugins.concat('app.js'))
        .pipe(gulp.dest('web/js/'))
        .pipe(plugins.uglify({mangle: true}))
        .pipe(plugins.rename({suffix: '.min'}))
        .pipe(gulp.dest('web/js/'));
});

gulp.task('watch', function() {
    gulp.watch(app + '/less/**/*.less', ['less']);
});


gulp.task(
    'build',
    [
        'copy',
        'concat',
        'less'
    ]
);

gulp.task(
    'default',
    [
        'less'
    ]
);
