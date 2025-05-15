<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
                <img src="/admin-assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
                    height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
        <div class="container-fluid">

            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <x-header-notification-component />

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ Auth::guard('admin')->user()->avatar ? Auth::guard('admin')->user()->avatar : '/uploads/avatars/avatar.png' }}"
                                alt="..." class="avatar-img rounded-circle">
                        </div>
                        <span class="profile-username">
                            <span class="fw-bold">{{ auth()->guard('admin')->user()->name }}</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img src="{{ Auth::guard('admin')->user()->avatar ? Auth::guard('admin')->user()->avatar : '/uploads/avatars/avatar.png' }}"
                                            alt="..." class="avatar-img rounded-circle">
                                    </div>
                                    <div class="u-text">
                                        <h4>{{ auth()->guard('admin')->user()->name }}</h4>
                                        <p class="text-muted">{{ auth()->guard('admin')->user()->email }}</p>
                                        <a href="{{ route('admin.profile') }}"
                                            class="btn btn-xs btn-secondary btn-sm">Thông tin cá
                                            nhân</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.edit-account') }}"><i
                                        class="icon-pencil me-2"></i>Cài đặt tài
                                    khoản</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.change-password') }}"><i
                                        class="icon-lock-open me-2"></i>Đổi mật
                                    khẩu</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"><i
                                        class="icon-logout me-2"></i>Đăng xuất</a>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
