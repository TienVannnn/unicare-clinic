<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('admin.dashboard') }}" class="logo" style="width:100%; flex; justify-content: center">
                <img src="/admin-assets/img/logo.png" alt="navbar brand" class="navbar-brand" style="height: 50px" />
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
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Trang chủ</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Quản lý</h4>
                </li>
                @can('xem-danh-sach-quyen')
                    <li class="nav-item {{ request()->routeIs('permission.*') ? 'active' : '' }}">
                        <a href="{{ route('permission.index') }}">
                            <i class="icon-user-following"></i>
                            <p>Quyền truy cập</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-vai-tro')
                    <li class="nav-item {{ request()->routeIs('role.*') ? 'active' : '' }}">
                        <a href="{{ route('role.index') }}">
                            <i class="fas fa-users-cog"></i>
                            <p>Vai trò</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-nhan-vien')
                    <li class="nav-item {{ request()->routeIs('manager.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.index') }}">
                            <i class="fas fa-users"></i>
                            <p>Người quản lý</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-loai-thuoc')
                    <li class="nav-item {{ request()->routeIs('medicine-category.*') ? 'active' : '' }}">
                        <a href="{{ route('medicine-category.index') }}">
                            <i class="fas fa-th-list"></i>
                            <p>Loại thuốc</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-thuoc')
                    <li class="nav-item {{ request()->routeIs('medicine.*') ? 'active' : '' }}">
                        <a href="{{ route('medicine.index') }}">
                            <i class="fas fa-capsules"></i>
                            <p>Thuốc</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-thuoc')
                    <li class="nav-item {{ request()->routeIs('clinic.*') ? 'active' : '' }}">
                        <a href="{{ route('clinic.index') }}">
                            <i class="fas fa-hospital-alt"></i>
                            <p>Phòng khám</p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#base">
                        <i class="fas fa-layer-group"></i>
                        <p>Base</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="components/avatars.html">
                                    <span class="sub-item">Avatars</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/buttons.html">
                                    <span class="sub-item">Buttons</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/gridsystem.html">
                                    <span class="sub-item">Grid System</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/panels.html">
                                    <span class="sub-item">Panels</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/notifications.html">
                                    <span class="sub-item">Notifications</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/sweetalert.html">
                                    <span class="sub-item">Sweet Alert</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/font-awesome-icons.html">
                                    <span class="sub-item">Font Awesome Icons</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/simple-line-icons.html">
                                    <span class="sub-item">Simple Line Icons</span>
                                </a>
                            </li>
                            <li>
                                <a href="components/typography.html">
                                    <span class="sub-item">Typography</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="widgets.html">
                        <i class="fas fa-desktop"></i>
                        <p>Widgets</p>
                        <span class="badge badge-success">4</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
