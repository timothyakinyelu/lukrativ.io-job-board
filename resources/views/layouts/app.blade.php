<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script> window.Laravel = { csrfToken: 'csrf_token() ' } </script>

    <title>{{ config('app.name', 'lukrativ.io') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Livvic|Montserrat|Philosopher|ZCOOL+XiaoWei|Srisakdi:700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.6.95/css/materialdesignicons.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <router-view ></router-view>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" ></script>
</body>
</html>
