<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>

    @include('user.layout.head')
    @yield('css')
</head>

<body>
    {{-- <div class="preloader">
        <div class="loader">
            <div class="loader-outter"></div>
            <div class="loader-inner"></div>

            <div class="indicator">
                <svg width="16px" height="12px">
                    <polyline id="back" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                    <polyline id="front" points="1 6 4 6 6 11 10 1 12 6 15 6"></polyline>
                </svg>
            </div>
        </div>
    </div> --}}

    <!-- Header Area -->
    @include('user.layout.header')
    <!-- End Header Area -->

    @yield('content')

    @include('user.layout.footer')

    @include('user.layout.script')
    @yield('js')
</body>

</html>
