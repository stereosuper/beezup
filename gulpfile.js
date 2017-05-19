var gulp = require('gulp');
var $ = require('gulp-load-plugins')();

var browserSync = require('browser-sync');
var reload = browserSync.reload;

var browserify = require('browserify');
var babelify = require('babelify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var sitemap = require('gulp-sitemap');

var reportError = function(error) {
    $.notify({
        title: 'An error occured with a Gulp task',
        message: 'Check you terminal for more informations'
    }).write(error);

    console.log(error.toString());
    this.emit('end');
};


gulp.task('styles', function () {
    return gulp.src('src/scss/main.scss')
        .pipe($.sourcemaps.init())
        .pipe($.sass({
            precision: 6, outputStyle: 'compressed', sourceComments: false, indentWidth: 4,
        }))
        .on('error', reportError)
        .pipe($.autoprefixer({
            browsers: [
            'ie >= 10',
            'ie_mob >= 10',
            'ff >= 30',
            'chrome >= 34',
            'safari >= 7',
            'opera >= 23',
            'ios >= 7',
            'android >= 4.4',
            'bb >= 10'
            ]
        }))
        .pipe($.sourcemaps.write())
        .pipe(gulp.dest('dest/wp-content/themes/beezup/css'))
        .pipe($.size({title: 'styles'}));
});

gulp.task('fonts', function() {
    return gulp.src('src/fonts/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/beezup/fonts'))
        .pipe($.size({ title: 'fonts' }));
});

gulp.task('img', function() {
    return gulp.src('src/img/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/beezup/img'))
        .pipe($.size({ title: 'img' }));
});

gulp.task('layoutImg', function() {
    return gulp.src('src/layoutImg/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/beezup/layoutImg'))
        .pipe($.size({ title: 'layoutImg' }));
});

gulp.task('js', function () {
    return browserify('src/js/main.js')
        .transform(babelify.configure({
            presets: ['es2015']
        }))
        .bundle()
        .pipe(source('main.js'))
        .pipe(buffer())
        .pipe($.uglify())
        .pipe(gulp.dest('dest/wp-content/themes/beezup/js'));
});


gulp.task('theme', function() {
    return gulp.src('src/theme/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/beezup'))
        .pipe($.size({title: 'theme'}));
});

gulp.task('root', function() {
    return gulp.src('src/*.*')
        .pipe(gulp.dest('dest'))
        .pipe($.size({title: 'root'}));
});


gulp.task('watch', function () {

    browserSync({
        notify: false,
        proxy: 'localhost'
    });


    $.watch('src/scss/**/*', function(){
        gulp.start(['styles'], reload);
    });

    $.watch('src/theme/**/*', function(){
        gulp.start(['theme'], reload);
    });

    $.watch('src/fonts/**/*', function(){
        gulp.start(['fonts'], reload);
    });
    $.watch('src/img/**/*', function(){
        gulp.start(['img'], reload);
    });
    $.watch('src/layoutImg/**/*', function(){
        gulp.start(['layoutImg'], reload);
    });
    $.watch('src/js/**/*', function(){
        gulp.start(['js'], reload);
    });

    $.watch('src/**', function(){
        gulp.start(['root'], reload);
    });
});


gulp.task('start', ['styles', 'theme', 'fonts', 'img', 'layoutImg', 'js', 'root']);

