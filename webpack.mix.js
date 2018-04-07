let mix = require('laravel-mix');

mix.browserSync({
  proxy: 'laravel-auth.test',
  notify: false
});

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');
