<!DOCTYPE html>
<html>
    <head>
        @include('partials.head')
    </head>
    <body>
        @include('partials.user_header')

        <!-- Your Page Content Here -->
        @yield('content')

        @include('partials.footer')
    </body>
</html>
