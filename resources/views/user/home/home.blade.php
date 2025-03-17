@extends('user.layout.main')
@section('css')
    <style>
        .text-stroke {
            color: white !important;
            text-shadow: 2px 2px 4px black;
            font-weight: 500 !important
        }

        .form-custom {
            display: block !important;
            width: 100%;
            height: 50px;
            border-radius: 5px;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('user/assets/js/custom/book-appointment.js') }}"></script>
@endsection
@section('content')
    <section class="slider">
        <div class="hero-slider">
            <div class="single-slider" style="background-image: url('/user/assets/img/tiep_don_01.jpg')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="text">
                                <h1>
                                    Chúng tôi cung cấp các <span>dịch vụ</span> y tế mà bạn
                                    <span>cần!</span>
                                </h1>
                                <p class="text-stroke">
                                    Đặt lịch khám, lấy mẫu
                                </p>
                                <div class="button">
                                    <a href="#" class="btn">Đặt lịch khám</a>
                                    <a href="#" class="btn primary">Xem thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-slider" style="background-image: url('/user/assets/img/tiep_don_02.jpg')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="text">
                                <h1>
                                    Chúng tôi cung cấp các <span>dịch vụ</span> y tế mà bạn
                                    <span>cần!</span>
                                </h1>
                                <p class="text-stroke">
                                    Khám sức khỏe tổng quát
                                </p>
                                <div class="button">
                                    <a href="#" class="btn">Đặt lịch khám</a>
                                    <a href="#" class="btn primary">Xem thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-slider" style="background-image: url('/user/assets/img/tiep_don_03.jpg')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="text">
                                <h1>
                                    Chúng tôi cung cấp các <span>dịch vụ</span> y tế mà bạn
                                    <span>cần!</span>
                                </h1>
                                <p class="text-stroke">
                                    Bảng giá dịch vụ
                                </p>
                                <div class="button">
                                    <a href="#" class="btn">Đặt lịch khám</a>
                                    <a href="#" class="btn primary">Xem thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="schedule">
        <div class="container">
            <div class="schedule-inner">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-schedule first">
                            <div class="inner">
                                <div class="icon">
                                    <i class="fa fa-ambulance"></i>
                                </div>
                                <div class="single-content">
                                    <span>Lorem Amet</span>
                                    <h4>Emergency Cases</h4>
                                    <p>
                                        Lorem ipsum sit amet consectetur adipiscing elit. Vivamus
                                        et erat in lacus convallis sodales.
                                    </p>
                                    <a href="#">Xem thêm<i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-schedule middle">
                            <div class="inner">
                                <div class="icon">
                                    <i class="icofont-prescription"></i>
                                </div>
                                <div class="single-content">
                                    <span>Fusce Porttitor</span>
                                    <h4>Doctors Timetable</h4>
                                    <p>
                                        Lorem ipsum sit amet consectetur adipiscing elit. Vivamus
                                        et erat in lacus convallis sodales.
                                    </p>
                                    <a href="#">Xem thêm<i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="single-schedule last">
                            <div class="inner">
                                <div class="icon">
                                    <i class="icofont-ui-clock"></i>
                                </div>
                                <div class="single-content">
                                    <span>Donec luctus</span>
                                    <h4>Opening Hours</h4>
                                    <ul class="time-sidual">
                                        <li class="day">
                                            Monday - Fridayp <span>8.00-20.00</span>
                                        </li>
                                        <li class="day">Saturday <span>9.00-18.30</span></li>
                                        <li class="day">
                                            Monday - Thusday <span>9.00-15.00</span>
                                        </li>
                                    </ul>
                                    <a href="#">Xem thêm<i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="appointment">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Chúng tôi luôn sẵn sàng giúp đỡ bạn. Đặt lịch hẹn</h2>
                        <img src="/user/assets/img/section-img.png" alt="#" />
                        <p>
                            Sức khỏe của bạn là ưu tiên hàng đầu – Hãy đặt lịch khám ngay để được chăm sóc tốt nhất!
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <form class="form" id="book-appointment-form" action="{{ route('user.book-appointment') }}"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Họ tên</label>
                                    <input name="name" id="name" type="text" placeholder="Nhập tên" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input name="email" id="email" type="email" placeholder="Nhập email" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Điện thoại</label>
                                    <input name="phone" id="phone" type="text"
                                        placeholder="Nhập số điện thoại" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="dob" class="form-label">Ngày sinh</label>
                                    <input name="dob" id="dob" type="date" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="gender" class="form-label">Giới tính</label>
                                    <select name="gender" id="gender" class="form-custom">
                                        <option value="1">Nam</option>
                                        <option value="2">Nam</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="department" class="form-label">Chuyên khoa</label>
                                <select name="department_id" class="form-custom">
                                    <option value="" selected>Chọn chuyên khoa</option>
                                    @if ($departments)
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="doctor" class="form-label">Bác sĩ</label>
                                    <select name="doctor_id" class="form-custom">
                                        <option value="" selected>Chọn bác sĩ</option>
                                        @if ($doctors)
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="time" class="form-label">Thời gian khám</label>
                                    <input type="datetime-local" name="time" id="time">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label for="note" class="form-label">Ghi chú</label>
                                    <textarea name="note" id="note" placeholder="Nhập ghi chú....."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-3 col-12">
                                <div class="form-group">
                                    <div class="button">
                                        <button type="submit" class="btn">
                                            Gửi yêu cầu
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-9 col-12">
                                <p>(Chúng tôi sẽ xác nhận bằng tin nhắn của bạn)</p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="appointment-image">
                        <img src="/user/assets/img/contact-img.png" alt="#" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="Feautes section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Chúng tôi luôn sẵn sàng giúp bạn và gia đình bạn</h2>
                        <img src="/user/assets/img/section-img.png" alt="#" />
                        <p>
                            Sức khỏe của bạn là ưu tiên hàng đầu – Hãy đặt lịch khám ngay để được chăm sóc tốt nhất!
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-12">
                    <div class="single-features">
                        <div class="signle-icon">
                            <i class="icofont icofont-ambulance-cross"></i>
                        </div>
                        <h3>Trợ giúp khẩn cấp</h3>
                        <p>
                            Cần trợ giúp khẩn cấp? Liên hệ ngay với chúng tôi để được hỗ trợ kịp thời!
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="single-features">
                        <div class="signle-icon">
                            <i class="icofont icofont-medical-sign-alt"></i>
                        </div>
                        <h3>Dược phẩm phong phú</h3>
                        <p>
                            Dược phẩm đa dạng, chất lượng – Đáp ứng mọi nhu cầu chăm sóc sức khỏe của bạn!
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="single-features last">
                        <div class="signle-icon">
                            <i class="icofont icofont-stethoscope"></i>
                        </div>
                        <h3>Điều trị y tế</h3>
                        <p>
                            Dịch vụ điều trị y tế chuyên nghiệp – Chăm sóc tận tâm, phục hồi sức khỏe nhanh chóng!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="fun-facts" class="fun-facts section overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-fun">
                        <i class="icofont icofont-home"></i>
                        <div class="content">
                            <span class="counter">3468</span>
                            <p>Phòng khám</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-fun">
                        <i class="icofont icofont-user-alt-3"></i>
                        <div class="content">
                            <span class="counter">557</span>
                            <p>Bác sĩ chuyên gia</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-fun">
                        <i class="icofont-simple-smile"></i>
                        <div class="content">
                            <span class="counter">4379</span>
                            <p>Bệnh nhân hạnh phúc</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-fun">
                        <i class="icofont icofont-table"></i>
                        <div class="content">
                            <span class="counter">32</span>
                            <p>Năm kinh nghiệm</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="portfolio section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Chúng tôi duy trì các quy tắc sạch sẽ bên trong bệnh viện của chúng tôi</h2>
                        <img src="/user/assets/img/section-img.png" alt="#" />
                        <p>
                            Chúng tôi luôn tuân thủ nghiêm ngặt các quy tắc vệ sinh để đảm bảo môi trường bệnh viện sạch sẽ
                            và an toàn cho mọi bệnh nhân
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="owl-carousel portfolio-slider">
                        <div class="single-pf">
                            <img src="/user/assets/img/pf1.jpg" alt="#" />
                            <a href="portfolio-details.html" class="btn">View Details</a>
                        </div>
                        <div class="single-pf">
                            <img src="/user/assets/img/pf2.jpg" alt="#" />
                            <a href="portfolio-details.html" class="btn">View Details</a>
                        </div>
                        <div class="single-pf">
                            <img src="/user/assets/img/pf3.jpg" alt="#" />
                            <a href="portfolio-details.html" class="btn">View Details</a>
                        </div>
                        <div class="single-pf">
                            <img src="/user/assets/img/pf4.jpg" alt="#" />
                            <a href="portfolio-details.html" class="btn">View Details</a>
                        </div>
                        <div class="single-pf">
                            <img src="/user/assets/img/pf1.jpg" alt="#" />
                            <a href="portfolio-details.html" class="btn">View Details</a>
                        </div>
                        <div class="single-pf">
                            <img src="/user/assets/img/pf2.jpg" alt="#" />
                            <a href="portfolio-details.html" class="btn">View Details</a>
                        </div>
                        <div class="single-pf">
                            <img src="/user/assets/img/pf3.jpg" alt="#" />
                            <a href="portfolio-details.html" class="btn">View Details</a>
                        </div>
                        <div class="single-pf">
                            <img src="/user/assets/img/pf4.jpg" alt="#" />
                            <a href="portfolio-details.html" class="btn">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="services section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Chúng tôi cung cấp các dịch vụ khác nhau để cải thiện sức khỏe của bạn</h2>
                        <img src="/user/assets/img/section-img.png" alt="#" />
                        <p>
                            Chúng tôi cung cấp đa dạng dịch vụ y tế nhằm nâng cao sức khỏe và chất lượng cuộc sống của bạn
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service">
                        <i class="icofont icofont-prescription"></i>
                        <h4><a href="service-details.html">Gói Khám Sức Khỏe Cơ Bản</a></h4>
                        <p>
                            Sức khỏe là vàng nhưng thực tế hiện nay có không ít người vẫn còn chần chừ chưa chủ động đi kiểm
                            tra, tầm soát sức
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service">
                        <i class="icofont icofont-tooth"></i>
                        <h4><a href="service-details.html">Đặt lịch khám lấy mẫu
                            </a></h4>
                        <p>
                            Quý khách vui lòng Đặt lịch hẹn online qua trang web hoặc hotline (0258) 3871 134
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service">
                        <i class="icofont icofont-heart-alt"></i>
                        <h4><a href="service-details.html">Bảng giá</a></h4>
                        <p>
                            Bảng giá dịch vụ sẽ của UNI CARE sẽ được hiển thị trên website của chúng tôi hoặc gọi qua
                            hotline (0258) 3871 134
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service">
                        <i class="icofont icofont-listening"></i>
                        <h4><a href="service-details.html">Khám chữa bệnh chủ động</a></h4>
                        <p>
                            Quý khách vui lòng đến địa chỉ 59 LÊ THÀNH PHƯƠNG, P. PHƯƠNG SÀI, TP. NHA TRANG để được các bác
                            sĩ chuyên
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service">
                        <i class="icofont icofont-eye-alt"></i>
                        <h4><a href="service-details.html">Hội chẩn chuyên gia Hồ Chí Minh và Hà Nội</a></h4>
                        <p>
                            Đội ngũ bác sĩ chuyên môn giỏi, giàu kinh nghiệm. Tất cả các bác sĩ và kỹ thuật viên tại đây với
                            nhiều năm kinh nghiệm,...
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service">
                        <i class="icofont icofont-blood"></i>
                        <h4><a href="service-details.html">Tư vấn online</a></h4>
                        <p>
                            Quý khách vui lòng đặt câu hỏi online qua trang web của chúng tôi hoặc hotline (0258) 3871 134
                            để được tư vấn trực...
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="blog section" id="blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Theo kịp với tin tức y tế gần đây nhất của chúng tôi.</h2>
                        <img src="/user/assets/img/section-img.png" alt="#" />
                        <p>
                            Theo dõi tin tức y tế mới nhất từ chúng tôi để luôn cập nhật thông tin sức khỏe quan trọng
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($news->isNotEmpty())
                    @foreach ($news as $new)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-news">
                                <div class="news-head">
                                    <img src="{{ $new->thumbnail }}" alt="#" style="height: 197px" />
                                </div>
                                <div class="news-body">
                                    <div class="news-content">
                                        <div class="date">{{ \Carbon\Carbon::parse($new->created_at)->format('d/m/Y') }}
                                        </div>
                                        <h2>
                                            <a href="blog-single.html">{{ $new->title }}</a>
                                        </h2>
                                        <p class="text">
                                            {!! Str::limit(strip_tags($new->content), 150, '...') !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <div class="clients overlay">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="owl-carousel clients-slider">
                        <div class="single-clients">
                            <img src="/user/assets/img/client1.png" alt="#" />
                        </div>
                        <div class="single-clients">
                            <img src="/user/assets/img/client2.png" alt="#" />
                        </div>
                        <div class="single-clients">
                            <img src="/user/assets/img/client3.png" alt="#" />
                        </div>
                        <div class="single-clients">
                            <img src="/user/assets/img/client4.png" alt="#" />
                        </div>
                        <div class="single-clients">
                            <img src="/user/assets/img/client5.png" alt="#" />
                        </div>
                        <div class="single-clients">
                            <img src="/user/assets/img/client1.png" alt="#" />
                        </div>
                        <div class="single-clients">
                            <img src="/user/assets/img/client2.png" alt="#" />
                        </div>
                        <div class="single-clients">
                            <img src="/user/assets/img/client3.png" alt="#" />
                        </div>
                        <div class="single-clients">
                            <img src="/user/assets/img/client4.png" alt="#" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
