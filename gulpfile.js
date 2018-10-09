const gulp = require('gulp');
const $ = require('gulp-load-plugins')();

const browserSync = require('browser-sync');

const reload = browserSync.reload;

const browserify = require('browserify');
const babelify = require('babelify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');

const reportError = function(error) {
    $.notify({
        title: 'An error occured with a Gulp task',
        message: 'Check you terminal for more informations',
    }).write(error);

    console.log(error.toString());
    this.emit('end');
};

gulp.task('styles', () =>
    gulp
        .src('src/scss/main.scss')
        // .pipe($.sourcemaps.init())
        .pipe(
            $.sass({
                precision: 6,
                outputStyle: 'compressed',
                sourceComments: false,
                indentWidth: 4,
            })
        )
        .on('error', reportError)
        .pipe(
            $.autoprefixer({
                browsers: [
                    'ie >= 10',
                    'ie_mob >= 10',
                    'ff >= 30',
                    'chrome >= 34',
                    'safari >= 7',
                    'opera >= 23',
                    'ios >= 7',
                    'android >= 4.4',
                    'bb >= 10',
                ],
            })
        )
        // .pipe($.sourcemaps.write())
        .pipe(gulp.dest('dest/wp-content/themes/beezup/css'))
        .pipe($.size({ title: 'styles' }))
);

gulp.task('fonts', () =>
    gulp
        .src('src/fonts/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/beezup/fonts'))
        .pipe($.size({ title: 'fonts' }))
);

gulp.task('img', () =>
    gulp
        .src('src/img/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/beezup/img'))
        .pipe($.size({ title: 'img' }))
);

gulp.task('layoutImg', () =>
    gulp
        .src('src/layoutImg/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/beezup/layoutImg'))
        .pipe($.size({ title: 'layoutImg' }))
);

gulp.task('js', () =>
    browserify({
        entries: 'src/js/main.js',
        debug: true,
    })
        .transform(
            babelify.configure({
                presets: ['es2015'],
            })
        )
        .bundle()
        .pipe(source('main.js'))
        .pipe(buffer())
        // .pipe($.sourcemaps.init({loadMaps: true}))
        .pipe($.uglify())
        // .pipe($.sourcemaps.write('./'))
        .pipe(gulp.dest('dest/wp-content/themes/beezup/js'))
        .pipe($.size({ title: 'js' }))
);

gulp.task('theme', () =>
    gulp
        .src('src/theme/**/*')
        .pipe(gulp.dest('dest/wp-content/themes/beezup'))
        .pipe($.size({ title: 'theme' }))
);

gulp.task('root', () =>
    gulp
        .src('src/*.*')
        .pipe(gulp.dest('dest'))
        .pipe($.size({ title: 'root' }))
);

gulp.task('watch', () => {
    browserSync({
        notify: false,
        proxy: 'localhost',
    });

    $.watch('src/scss/**/*', () => {
        gulp.start(['styles'], reload);
    });

    $.watch('src/theme/**/*', () => {
        gulp.start(['theme'], reload);
    });

    $.watch('src/fonts/**/*', () => {
        gulp.start(['fonts'], reload);
    });
    $.watch('src/img/**/*', () => {
        gulp.start(['img'], reload);
    });
    $.watch('src/layoutImg/**/*', () => {
        gulp.start(['layoutImg'], reload);
    });
    $.watch('src/js/**/*', () => {
        gulp.start(['js'], reload);
    });

    $.watch('src/*.*', () => {
        gulp.start(['root'], reload);
    });
});

gulp.task('start', [
    'styles',
    'theme',
    'fonts',
    'img',
    'layoutImg',
    'js',
    'root',
]);
