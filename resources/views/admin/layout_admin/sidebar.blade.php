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
                        <p class="text-capitalize">Trang chủ</p>
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
                            <p class="text-capitalize">Bệnh nhân</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-giay-kham-benh')
                    <li class="nav-item {{ request()->routeIs('medical-certificate.*') ? 'active' : '' }}">
                        <a href="{{ route('medical-certificate.index') }}">
                            <i class="fas fa-address-card"></i>
                            <p class="text-capitalize">Giấy khám bệnh</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-don-thuoc')
                    <li class="nav-item {{ request()->routeIs('prescription.*') ? 'active' : '' }}">
                        <a href="{{ route('prescription.index') }}">
                            <i class="fas fa-briefcase-medical"></i>
                            <p class="text-capitalize">Đơn thuốc</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-lien-he')
                    <li class="nav-item {{ request()->routeIs('contact.*') ? 'active' : '' }}">
                        <a href="{{ route('contact.index') }}">
                            <i class="fa fa-envelope"></i>
                            <p class="text-capitalize">Liên hệ</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-lich-hen-kham')
                    <li class="nav-item {{ request()->routeIs('appointment.*') ? 'active' : '' }}">
                        <a href="{{ route('appointment.index') }}">
                            <i class="fa fa-bell"></i>
                            <p class="text-capitalize">Lịch hẹn khám</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-loai-thuoc')
                    <li class="nav-item {{ request()->routeIs('medicine-category.*') ? 'active' : '' }}">
                        <a href="{{ route('medicine-category.index') }}">
                            <i class="fas fa-th-list"></i>
                            <p class="text-capitalize">Loại thuốc</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-thuoc')
                    <li class="nav-item {{ request()->routeIs('medicine.*') ? 'active' : '' }}">
                        <a href="{{ route('medicine.index') }}">
                            <i class="fas fa-capsules"></i>
                            <p class="text-capitalize">Thuốc</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-chuyen-khoa')
                    <li class="nav-item {{ request()->routeIs('department.*') ? 'active' : '' }}">
                        <a href="{{ route('department.index') }}">
                            <i class="fas fa-calendar-alt"></i>
                            <p class="text-capitalize">Chuyên khoa</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-phong-kham')
                    <li class="nav-item {{ request()->routeIs('clinic.*') ? 'active' : '' }}">
                        <a href="{{ route('clinic.index') }}">
                            <i class="fas fa-hospital-alt"></i>
                            <p class="text-capitalize">Phòng khám</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-dich-vu-kham')
                    <li class="nav-item {{ request()->routeIs('medical-service.*') ? 'active' : '' }}">
                        <a href="{{ route('medical-service.index') }}">
                            <i class="fas fa-calendar-plus"></i>
                            <p class="text-capitalize">Dịch vụ khám</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-muc-tin-tuc')
                    <li class="nav-item {{ request()->routeIs('news-category.*') ? 'active' : '' }}">
                        <a href="{{ route('news-category.index') }}">
                            <i class="fas fa-tags"></i>
                            <p class="text-capitalize">Danh mục tin tức</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-tin-tuc')
                    <li class="nav-item {{ request()->routeIs('news.*') ? 'active' : '' }}">
                        <a href="{{ route('news.index') }}">
                            <i class="fas fa-tag"></i>
                            <p class="text-capitalize">Tin tức</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-tin-tuc')
                    <li class="nav-item {{ request()->routeIs('faq.*') ? 'active' : '' }}">
                        <a href="{{ route('faq.index') }}">
                            <i class="fas fa-tag"></i>
                            <p class="text-capitalize">Hỏi đáp</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-nguoi-dung')
                    <li class="nav-item {{ request()->routeIs('user.*') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}">
                            <i class="fas fa-users"></i>
                            <p class="text-capitalize">Người dùng</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-nhan-vien')
                    <li class="nav-item {{ request()->routeIs('manager.*') ? 'active' : '' }}">
                        <a href="{{ route('manager.index') }}">
                            <i class="fas fa-user"></i>
                            <p class="text-capitalize">Nhân viên</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-vai-tro')
                    <li class="nav-item {{ request()->routeIs('role.*') ? 'active' : '' }}">
                        <a href="{{ route('role.index') }}">
                            <i class="fas fa-users-cog"></i>
                            <p class="text-capitalize">Vai trò</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-quyen')
                    <li class="nav-item {{ request()->routeIs('permission.*') ? 'active' : '' }}">
                        <a href="{{ route('permission.index') }}">
                            <i class="icon-user-following"></i>
                            <p class="text-capitalize">Quyền truy cập</p>
                        </a>
                    </li>
                @endcan
                @can('xem-danh-sach-menu')
                    <li class="nav-item {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                        <a href="{{ route('menu.index') }}">
                            <i class="fas fa-sitemap"></i>
                            <p class="text-capitalize">Menu Site</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>
