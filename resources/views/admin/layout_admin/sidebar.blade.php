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
                @can('xem-danh-sach-benh-nhan')
                    <li class="nav-item {{ request()->routeIs('patient.*') ? 'active' : '' }}">
                        <a href="{{ route('patient.index') }}">
                            <i class="fas fa-address-book"></i>
                            <p>Bệnh nhân</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-giay-kham-benh')
                    <li class="nav-item {{ request()->routeIs('medical-certificate.*') ? 'active' : '' }}">
                        <a href="{{ route('medical-certificate.index') }}">
                            <i class="fas fa-address-card"></i>
                            <p>Giấy khám bệnh</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-don-thuoc')
                    <li class="nav-item {{ request()->routeIs('prescription.*') ? 'active' : '' }}">
                        <a href="{{ route('prescription.index') }}">
                            <i class="fas fa-briefcase-medical"></i>
                            <p>Đơn thuốc</p>
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
                @can('xem-danh-sach-chuyen-khoa')
                    <li class="nav-item {{ request()->routeIs('department.*') ? 'active' : '' }}">
                        <a href="{{ route('department.index') }}">
                            <i class="fas fa-calendar-alt"></i>
                            <p>Chuyên khoa</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-phong-kham')
                    <li class="nav-item {{ request()->routeIs('clinic.*') ? 'active' : '' }}">
                        <a href="{{ route('clinic.index') }}">
                            <i class="fas fa-hospital-alt"></i>
                            <p>Phòng khám</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-dich-vu-kham')
                    <li class="nav-item {{ request()->routeIs('medical-service.*') ? 'active' : '' }}">
                        <a href="{{ route('medical-service.index') }}">
                            <i class="fas fa-calendar-plus"></i>
                            <p>Dịch vụ khám</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-nhan-vien')
                    <li class="nav-item {{ request()->routeIs('manager.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.index') }}">
                            <i class="fas fa-users"></i>
                            <p>Nhân viên</p>
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
                @can('xem-danh-sach-quyen')
                    <li class="nav-item {{ request()->routeIs('permission.*') ? 'active' : '' }}">
                        <a href="{{ route('permission.index') }}">
                            <i class="icon-user-following"></i>
                            <p>Quyền truy cập</p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#setting">
                        <i class="fas fa-cog"></i>
                        <p>Cài đặt</p>
                        <span class="badge badge-success">4</span>
                    </a>
                    <div class="collapse" id="setting">
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
            </ul>
        </div>
    </div>
</div>
