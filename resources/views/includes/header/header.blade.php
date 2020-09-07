<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }} &bull; @yield('title')</title>
        <!-- Fonts -->
        <!-- <link href="{{ url('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"> -->
        <!-- Styles -->
        <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">
        
        
        <!--Bootstrap Stylesheet [ REQUIRED ]-->
        <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">
        <!--Jasmine Stylesheet [ REQUIRED ]-->
        <!-- <link href="{{ url('css/style.css') }}" rel="stylesheet"> -->
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/style-overrides.css') }}" rel="stylesheet">
        <!--Font Awesome [ OPTIONAL ]-->
        <link href="{{ url('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <!--Switchery [ OPTIONAL ]-->
        <link href="{{ url('plugins/switchery/switchery.min.css') }}" rel="stylesheet">
        <!--Bootstrap Select [ OPTIONAL ]-->
        <link href="{{ url('plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet">
        <!-- <link href="{{ url('plugins/tag-it/jquery.tagit.css') }}" rel="stylesheet"> -->
        <!--Bootstrap Table [ OPTIONAL ]-->
        <link href="{{ url('plugins/datatables/media/css/dataTables.bootstrap.css') }}" rel="stylesheet">
        <link href="{{ url('plugins/datatables/extensions/Responsive/css/dataTables.responsive.css') }}" rel="stylesheet">


        <!-- Scripts -->
        <script src="{{ url('js/jquery-latest.min.js') }}"></script>
        <script src="{{ url('js/jquery-2.1.1.min.js') }}"></script>
    </head>
    <body>