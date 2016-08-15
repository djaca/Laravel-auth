var elixir = require('laravel-elixir');
var gulp = require('gulp');

gulp.task('fonts', function() {
    return gulp.src('node_modules/font-awesome/fonts/*')
        .pipe(gulp.dest('public/build/fonts'))
})

elixir(function(mix) {
    mix.sass('app.scss')
        .webpack('app.js');

    mix.version(['css/app.css', 'js/app.js'])
});
