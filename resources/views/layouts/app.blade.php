<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <!--        app layout -->
    {{--    navigation bar  as component--}}
    <x-navbar/>
    {{--    navigation bar --}}
        <main class="py-4">
            <div class="container ">
                <div class="row justify-content-center">
                    {{--  left menu--}}
                    <div class="col-md-3">

                        @yield('menu')

                    </div>
                    {{-- left menu end --}}


                    {{-- right side content --}}
                    <div class="col-md-9">

                        @yield('content')

                    </div>
                    {{-- content end --}}
                </div>
            </div>
        </main>

    {{--  footer section   --}}
    <footer class="fixed-bottom">
        <div class="container text-center">
            <p>&copy;2021</p>
        </div>
    </footer>
    {{--    footer end--}}
</div>
@yield('page-script')
</body>
</html>
