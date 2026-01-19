const mix = require('laravel-mix');

mix.setPublicPath('source/assets/build');

mix.js('source/_assets/js/main.js', 'js')
   .css('source/_assets/css/main.css', 'css')
   .version();

mix.browserSync({
    server: 'build_local',
    files: ['build_local/**'],
});
