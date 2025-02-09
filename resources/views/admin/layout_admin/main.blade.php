<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout_admin.headonly')
    @yield('css')
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('admin.layout_admin.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            @include('admin.layout_admin.header')

            @yield('content')

            @include('admin.layout_admin.footer')
        </div>
    </div>

    @include('admin.layout_admin.script')
    @yield('js')

</body>

</html>
