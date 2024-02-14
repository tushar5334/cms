<!DOCTYPE html>
<html style="--main-color: #479bfb; --main-dark: #3292ff; --main-light: #e7f2fe;">
    <head>
        <title></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">        
    </head>
    <body>        
        @yield('content')                        
    </body>
    @include('front.include.javascripts')    
    @stack('custom-scripts')
    @include('front.include.functions')
    @include('front.include.flash-message')
</html>