import gulp from 'gulp';
import dartSass from 'sass';
import gulpSass from 'gulp-sass';

const sass = gulpSass(dartSass);

const paths = {
    scss: 'resources/scss/**/*.scss',
    dest: 'public/css',
};

function styles() {
    return gulp
        .src('resources/scss/main.scss')
        .pipe(sass({ style: 'expanded' }).on('error', sass.logError))
        .pipe(gulp.dest(paths.dest));
}

function watch() {
    gulp.watch(paths.scss, styles);
}

export { styles, watch };
export default styles;
