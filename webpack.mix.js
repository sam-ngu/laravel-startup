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

mix.setPublicPath('public');


mix.js('resources/js/public/app.js', 'js')
    .sass('resources/sass/app.scss', 'css')
    .extract([
        'axios',
        'lodash',
        'moment',
        'sweetalert2'
    ]);

if (mix.inProduction() || process.env.npm_lifecycle_event !== 'hot') {
    mix.version();
}

mix.options({
    hmrOptions: {
        host: 'laravel-startup.dev.local',
        port: 8080,
    }
});

// // fix css files 404 issue
mix.webpackConfig({
    devServer: {

        // https: {
        //     key: '/etc/ssl/private/default.key',
        //     cert: '/etc/ssl/private/default.crt',
        //     ca: '/etc/ssl/private/dhparam.pem',
        // },
        proxy: {
            host: '0.0.0.0',
            port: 8080,

        },
        watchOptions:{
            aggregateTimeout:200,
            poll:500
        },
        // plugins: [
        //     new webpack.EnvironmentPlugin(['MIX_PUBLISH_APP_URL']),
        // ],
    }
});
