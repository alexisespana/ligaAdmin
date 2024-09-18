<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Laravel')</title>

    <script src="{{ asset('js/config.js') }}"></script>
    <script src="{{ asset('js/simplebar.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/simplebar.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/theme.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/user-rtl.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/user.min.css') }}" type="text/css">



    @yield('css')
</head>

<body>
    @csrf

    <main class="main">
        <div class="container-fluid">

            @include('layouts.MenuVertical.MenuVertical', $menus)
            <div class="content">
                @include('layouts.header')

                <div class="container">
                    <div class="row mb-3">

                        @yield('content')
                    </div>
                    @include('layouts.Modal.Modal')

                </div>
            </div>
        </div>
    </main>
    {{-- @include('layouts.header', $notificacion) --}}



    </nav>

    <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/anchor.min.js') }}"></script>
    <script src="{{ asset('js/is.min.js') }}"></script>
    <script src="{{ asset('js/echarts.min.js') }}"></script>
    <script src="{{ asset('js/list.min.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>
    <script src="{{ asset('js/lodash.min.js') }}"></script>
    <script src="{{ asset('js/list.min.js') }}"></script>

    <script src="{{ asset('js/theme.js') }}"></script>

    <script></script>
    @yield('scripts')


</body>

</html>
