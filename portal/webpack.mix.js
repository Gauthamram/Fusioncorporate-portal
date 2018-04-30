let mix = require('laravel-mix');

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

//mix.js('resources/assets/js/app.js', 'public/js')
mix.js(['resources/assets/js/main.js','resources/assets/js/scripts.js'],'public/js/custom/main.js')
	.js('resources/assets/js/app.js', 'public/js')
	.styles(['resources/assets/css/app.css','resources/assets/css/custom-styles.css'], 'public/css/main.min.css')
	.styles('resources/assets/css/venobox.css', 'public/css/venobox.min.css');