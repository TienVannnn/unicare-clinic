<header class="header">
    <!-- Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7 col-12">
                    <!-- Contact -->
                    <ul class="top-contact">
                        <li><i class="fa fa-phone"></i>082.234.5959</li>
                        <li>
                            <i class="fa fa-envelope"></i><a href="mailto:info@unicaremedic.vn">info@unicaremedic.vn
                            </a>
                        </li>
                    </ul>
                    <!-- End Contact -->
                </div>
                <div class="col-lg-6 col-md-5 col-12">
                    <!-- Top Contact -->
                    <ul class="top-link">
                        <li class="">
                            <input type="search" class="form-control d-none" />
                            <a href="" class="input-search"><i class="fa fa-search"></i></a>
                        </li>
                        <li>
                            <i class="fa fa-envelope mr-1"></i><a href="mailto:support@yourmail.com">Vi</a>
                        </li>
                        @if (Auth::check())
                            <li>
                                <a href="{{ route('user.overview') }}"><i
                                        class="fa fa-user
                                    mr-1"></i>{{ Auth::user()->name }}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('user.login') }}">Đăng nhập</a>
                            </li>
                        @endif
                    </ul>
                    <!-- End Top Contact -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    <!-- Header Inner -->
    <div class="header-inner">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-12">
                        <!-- Start Logo -->
                        <div class="logo">
                            <a href="/"><img src="/user/assets/img/logocustom.png" alt="#" /></a>
                        </div>
                        <!-- End Logo -->
                        <!-- Mobile Nav -->
                        <div class="mobile-nav"></div>
                        <!-- End Mobile Nav -->
                    </div>
                    <div class="col-lg-7 col-md-9 col-12">
                        <!-- Main Menu -->
                        <div class="main-menu">
                            <nav class="navigation">
                                <ul class="nav menu">
                                    <li class="active">
                                        <a href="#">Trang chủ <i class="icofont-rounded-down"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="/">Lịch sử hình thành và phát triển</a></li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="#">Dịch vụ <i class="icofont-rounded-down"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="/">Đặt lịch khám</a></li>
                                            <li><a href="/">Dịch vụ y tế</a></li>
                                            <li><a href="/">Hỏi đáp</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Chương trình ưu đãi </a></li>
                                    <li>
                                        <a href="#">Tin tức <i class="icofont-rounded-down"></i></a>
                                        <ul class="dropdown">
                                            <li><a href="#">Tin tức y học</a></li>
                                            <li><a href="#">Tin tức phòng khám</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Liên hệ</a></li>
                                </ul>
                            </nav>
                        </div>
                        <!--/ End Main Menu -->
                    </div>
                    <div class="col-lg-2 col-12">
                        <div class="get-quote">
                            <a href="appointment.html" class="btn">ĐẶT LỊCH</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ End Header Inner -->
</header>
