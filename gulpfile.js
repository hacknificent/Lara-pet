import gulp from 'gulp';
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
import terser from 'gulp-terser';

const sass = gulpSass(dartSass);

const paths = {
    scss: 'resources/scss/**/*.scss',
    js: 'resources/js/**/*.js',
    cssDest: 'public/css',
    jsDest: 'public/js',
};

function styles() {
    return gulp
        .src('resources/scss/main.scss')
        .pipe(sass({ style: 'expanded' }).on('error', sass.logError))
        .pipe(gulp.dest(paths.cssDest));
}

function scripts() {
    return gulp
        .src('resources/js/index-blade-scripts.js')
        .pipe(terser())
        .pipe(gulp.dest(paths.jsDest));
}

function watch() {
    gulp.watch(paths.scss, styles);
    gulp.watch(paths.js, scripts);
}

export { styles, scripts, watch };
export default gulp.series(styles, scripts);
