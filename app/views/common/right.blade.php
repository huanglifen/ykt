@extends('common.common')
<!-- BEGIN BODY -->
@section("content")
    <body class="page-header-fixed right-main-color" >
    @yield('context')
    <!-- END CONTAINER -->
    @stop
    @section("footer")
    @stop
    @section("otherJs")
        <script src="{{{$jsURL}}}app.js"></script>
        <script>
            jQuery(document).ready(function() {
                App.init();
            });
        </script>
@stop