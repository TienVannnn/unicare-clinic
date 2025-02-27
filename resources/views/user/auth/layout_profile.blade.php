@extends('user.layout.main')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-3 mb-4 mb-md-0">
                <div class="card shadow">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('user.overview') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('user.overview') ? 'active' : '' }}">
                            Tổng quan
                        </a>
                        <a href="{{ route('user.account-edit') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('user.account-edit') ? 'active' : '' }}">
                            Thay đổi hồ sơ
                        </a>
                        <a href="{{ route('user.change-password') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('user.change-password') ? 'active' : '' }}">
                            Đổi mật khẩu
                        </a>
                        <a onclick="return confirm('Bạn có chắc chắn muốn thoát không?')" href="{{ route('user.logout') }}"
                            class="list-group-item list-group-item-action text-danger">
                            Thoát
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card shadow">
                    <div class="card-body">
                        @yield('content_profile')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    @yield('js_profile')
@endsection
