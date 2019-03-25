let path = require('path');
let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js');
mix.copy('node_modules/vue-snotify/styles/material.css', 'public/css/vendor/notify.css');
mix.copy('node_modules/move-js/move.min.js', 'public/js/vendor/move.min.js');
mix.sass('resources/sass/app.scss', 'public/css')
   .options({
      processCssUrls: false,
      postCss: [tailwindcss('./tailwind.js')],
   })
   .extract(['vue', 'lodash', 'axios'])
   .disableNotifications()
   .webpackConfig({
      resolve: {
         alias: {
            JS: path.resolve(__dirname, 'resources/js'),
            App: path.resolve(__dirname, 'resources/js/app'),
            Helpers: path.resolve(__dirname, 'resources/js/helpers'),
            Libraries: path.resolve(__dirname, 'resources/js/lib'),
            Components: path.resolve(__dirname, 'resources/js/components'),
            Config: path.resolve(__dirname, 'resources/js/config'),
            LayoutComponents: path.resolve(__dirname, 'resources/js/components/Layout'),
            Events: path.resolve(__dirname, 'resources/js/events'),
            Mixins: path.resolve(__dirname, 'resources/js/mixins'),
            Models: path.resolve(__dirname, 'resources/js/models'),
            'vue$': 'vue/dist/vue.runtime.js'
         }
      },
      devtool: 'inline-source-map',
   })
   .version()
   .sourceMaps();