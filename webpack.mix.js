const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

// theme
// mix.styles('resources/assets/theme/css/*.css', 'public/css/theme.css')
//     .scripts('resources/assets/theme/js/*.js', 'public/js/theme.js');

// custom
// mix.styles('resources/assets/custom/css/*.css', 'public/css/custom.css')
// .scripts('resources/assets/custom/js/*.js', 'public/js/custom.js');
