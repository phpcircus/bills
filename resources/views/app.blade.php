<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="relative">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.typekit.net/tff8xri.css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/vendor/notify.css') }}" rel="stylesheet">
        <link href="{{ asset('css/vendor/vue-multiselect.css') }}" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ mix('/js/manifest.js') }}" defer></script>
        <script src="{{ mix('/js/vendor.js') }}" defer></script>
        <script src="{{ mix('/js/app.js') }}" defer></script>
        <script>
            window.StoneBill = <?php echo json_encode([
                                'notification' => get_notification(),
                                'error' => get_error(),
                            ]); ?>
        </script>

        <meta name="turbolinks-cache-control" content="no-cache">
    </head>
    <body class="bg-grey-lightest font-lato">
        <div id="app" data-component="{{ $name }}" data-props="{{ json_encode($data) }}"></div>
    </body>
</html>
