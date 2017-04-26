var gulp = require('gulp');
var $ = require('gulp-load-plugins')();

var browserSync = require('browser-sync');
var reload = browserSync.reload;

var browserify = require('browserify');
var babelify = require('babelify');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var sitemap = require('gulp-sitemap');

var del = require('del');
var path = require('path');

var report_error = function(error) {
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
        .on('error', report_error)
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
        .pipe(gulp.dest('dest/wp-content/themes/super/css'))
        .pipe($.size({title: 'styles'}));
});

gulp.task('fonts', function() {
    return gulp.src('src/fonts/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/super/fonts'))
        .pipe($.size({ title: 'fonts' }));
});

gulp.task('img', function() {
    return gulp.src('src/img/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/super/img'))
        .pipe($.size({ title: 'img' }));
});

gulp.task('layoutImg', function() {
    return gulp.src('src/layoutImg/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/super/layoutImg'))
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
        .pipe(gulp.dest('dest/wp-content/themes/super/js'));
});


gulp.task('theme', function() {
    return gulp.src('src/theme/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/super'))
        .pipe($.size({title: 'theme'}));
});


gulp.task('sitemap', function () {
    gulp.src('dest/wp-content/themes/super/**/*.html', {
            read: false
        })
        .pipe(sitemap({
            siteUrl: 'http://www.beezup.fr'
        }))
        .pipe(gulp.dest('dest/wp-content/themes/super'));
});

gulp.task('robots', function() {
    return gulp.src('src/robots.txt')
        .pipe(gulp.dest('dest/'))
        .pipe($.size({ title: 'robots' }));
});
gulp.task('htaccess', function() {
    return gulp.src('src/.htaccess')
        .pipe(gulp.dest('dest/'))
        .pipe($.size({ title: 'htaccess' }));
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
    
    $.watch('src/robots.txt', function(){
        gulp.start(['robots'], reload);
    });
    $.watch('src/.htaccess', function(){
        gulp.start(['htaccess'], reload);
    });
});


gulp.task('start', ['styles', 'theme', 'fonts', 'img', 'layoutImg', 'js', 'robots', 'htaccess', 'sitemap']);

