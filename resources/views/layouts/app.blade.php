<!DOCTYPE html>
<html>
    <head>
        @include('partials.head')
    </head>
    <body>
        @include('partials.header')

        <!-- Your Page Content Here -->
        @yield('content')

        @include('partials.footer')
    </body>
</html>
