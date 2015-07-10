var gulp = require('gulp'),
    plugins = require('gulp-load-plugins')(),
    argv = require('yargs').argv;

var ENV = 'env' in argv ? argv.env : 'dev';
var RES = 'app/Resources';

var onError = function(error)
{
    if (error.message) {
        plugins.util.log(
            plugins.util.colors.white.bgRed(error.message.replace("\n", ''))
        );
    } else {
        plugins.util.log(error);
    }
    plugins.util.beep();

    this.emit('end');
};

gulp.task(
    'less',
    function() {
        gulp.src(
            [
                RES + '/less/output/*.less'
            ]
        )
            .pipe(plugins.plumber({errorHandler: onError}))
            .pipe(plugins.less())
            .pipe(gulp.dest('web/css/'))
            .pipe(plugins.minifyCss({keepSpecialComments:0}))
            .pipe(plugins.rename({suffix: '.min'}))
            .pipe(gulp.dest('web/css/'));
    });

gulp.task(
    'js',
    function() {
        gulp.src(
            [
                RES + '/js/output/*.js'
            ]
        )
            .pipe(plugins.browserify({
                insertGlobals : false,
                debug : 'dev' !== ENV
            }))
            .pipe(gulp.dest('web/js/'))
            .pipe(plugins.uglify({mangle: true}))
            .pipe(plugins.rename({suffix: '.min'}))
            .pipe(gulp.dest('web/js/'));
    }
);

gulp.task(
    'vendor-css',
    function() {
        gulp.src(
            [
                RES + '/libs/bootstrap/fonts/*.{ttf,woff,woff2,eof,svg,eot}',
                RES + '/libs/font-awesome/fonts/*.{ttf,woff,woff2,eof,svg,eot}'
            ]
        )
            .pipe(gulp.dest('web/fonts/'));

        gulp.src(
            [
                RES + '/img/**'
            ]
        )
            .pipe(gulp.dest('web/img/'));

        gulp.src(
            [
                RES + '/less/vendor/bootstrap.less',
            ]
        )
            .pipe(plugins.plumber({errorHandler: onError}))
            .pipe(plugins.less())
            .pipe(gulp.dest('web/css/'))
            .pipe(plugins.minifyCss({keepSpecialComments:0}))
            .pipe(plugins.concat('vendor.min.css'))
            .pipe(gulp.dest('web/css/'));
    });

gulp.task(
    'vendor-js',
    function() {
        gulp.src(
            [
                RES + '/libs/jquery/dist/jquery.js',
                RES + '/libs/bootstrap/dist/js/bootstrap.js',
                RES + '/libs/bootstrap-datepicker/js/bootstrap-datepicker.js',
                RES + '/libs/bootstrap-datepicker/js/bootstrap-datepicker.pl.js',
                RES + '/libs/bootstrap-select/js/bootstrap-select.js',
                RES + '/libs/bootstrap-select/js/i18n/defaults-pl_PL.js',
                RES + '/libs/underscore/underscore.js',
                RES + '/libs/backbone/backbone.js',
            ]
        )
            .pipe(plugins.concat('vendor.js'))
            .pipe(gulp.dest('web/js/'))
            .pipe(plugins.uglify({mangle: true}))
            .pipe(plugins.rename({suffix: '.min'}))
            .pipe(gulp.dest('web/js/'));
    });

gulp.task(
    'watch',
    function() {
        gulp.watch(RES + '/less/**/*.less', ['less']);
        gulp.watch(RES + '/js/**/*.js', ['js']);
    }
);

gulp.task(
    'build',
    [
        'vendor-css',
        'vendor-js',
        'less',
        'js'
    ]
);

gulp.task(
    'default',
    [
        'less'
    ]
);