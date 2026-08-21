// webpack.mix.js

let mix = require('laravel-mix');

mix.setPublicPath('dist');

mix.sass('src/scss/styles.scss', 'css');
mix.js('src/js/main.js', 'js');
mix.copy('node_modules/bootstrap/dist/js/*.js', 'dist/js');

