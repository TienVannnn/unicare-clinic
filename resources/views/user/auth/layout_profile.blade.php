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
                        <a href="{{ route('user.medical-history') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('user.medical-history') ? 'active' : '' }}">
                            Lịch sử khám bệnh
                        </a>
                        <a href="{{ route('user.account-edit') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('user.account-edit') ? 'active' : '' }}">
                            Thay đổi hồ sơ
                        </a>
                        <a href="{{ route('user.change-password') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('user.change-password') ? 'active' : '' }}">
                            Đổi mật khẩu
                        </a>
                        <a href="{{ route('user.faq-auth') }}"
                            class="list-group-item list-group-item-action {{ request()->routeIs('user.faq-auth') ? 'active' : '' }}">
                            Hỏi đáp
                        </a>
                        <a onclick="return confirm('Bạn có chắc chắn muốn thoát không?')" href="{{ route('user.logout') }}"
                            class="list-group-item list-group-item-action text-danger">
                            Thoát
                        </a>
                        <a onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này không? Tất cả dữ liệu liên quan đến tài khoản sẽ mất hết?')"
                            href="{{ route('user.delete-account') }}"
                            class="list-group-item list-group-item-action text-danger">
                            Xóa tài khoản
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
