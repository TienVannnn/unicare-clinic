@extends('user.layout.main')
@section('content')
    <div class="breadcrumbs overlay banner-bread">
        <div class="container">
            <div class="bread-inner">
                <div class="row">
                    <div class="col-12">
                        <h2>Liên hệ với chúng tôi</h2>
                        <ul class="bread-list">
                            <li><a href="/">Trang chủ</a></li>
                            <li><i class="icofont-simple-right"></i></li>
                            <li class="active">Liên hệ với chúng tôi</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="contact-us section">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-us-left">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3899.002849300119!2d109.18637987482862!3d12.248085988004775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3170676d26f45145%3A0x53788443dbcf3da7!2zUGjDsm5nIGtow6FtIMSRYSBraG9hIFVuaSBDYXJl!5e0!3m2!1svi!2s!4v1740971492274!5m2!1svi!2s"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-us-form">
                            <h2>Liên hệ với chúng tôi</h2>
                            <p>
                                Nếu bạn có bất kỳ câu hỏi nào xin vui lòng liên hệ với chúng tôi.
                            </p>
                            <form class="form" method="post" action="{{ route('user.contact') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text"
                                                class="@error('name')
                                                is-invalid
                                            @enderror"
                                                value="{{ old('name') }}" name="name" placeholder="Nhập tên" />
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="email"
                                                class="@error('email')
                                            is-invalid
                                        @enderror"
                                                value="{{ old('email') }}" name="email" placeholder="Nhập email" />
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text"
                                                class="@error('phone')
                                            is-invalid
                                        @enderror"
                                                value="{{ old('phone') }}" name="phone"
                                                placeholder="Nhập số điện thoại" />
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input type="text"
                                                class="@error('title')
                                            is-invalid
                                        @enderror"
                                                value="{{ old('title') }}" name="title" placeholder="Nhập tiêu đề" />
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <textarea name="message"
                                                class="@error('message')
                                            is-invalid
                                        @enderror"
                                                placeholder="Nhập nội dung">{{ old('message') }}</textarea>
                                            @error('message')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group login-btn">
                                            <button class="btn" type="submit">Gửi</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-info">
                <div class="row">
                    <!-- single-info -->
                    <div class="col-lg-4 col-12">
                        <div class="single-info">
                            <i class="icofont icofont-ui-call"></i>
                            <div class="content">
                                <h3>+082.234.5959</h3>
                                <p>info@unicaremedic.vn</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="single-info">
                            <i class="icofont-google-map"></i>
                            <div class="content">
                                <h3>Địa chỉ</h3>
                                <p>59 Lê Thành Phương, Phường Phương Sài, TP. Nha Trang</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="single-info">
                            <i class="icofont icofont-wall-clock"></i>
                            <div class="content">
                                <h3>Giờ làm việc</h3>
                                <p>Thứ 2 - Chủ Nhật: 06:00–11:30, 14:00–18:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
