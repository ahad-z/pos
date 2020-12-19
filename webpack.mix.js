const mix = require('laravel-mix');


mix.copyDirectory('resources/sass/pos/assets/img','public/images');

mix.styles([
    'resources/sass/pos/assets/css/sb-admin-2.min.css',
], 'public/css/plugins.css');


mix.js('resources/js/app.js', 'public/js');

mix.sass('resources/sass/app.scss', 'public/css');
