@extends('user.layout.main')

@section('content')
    <div class="breadcrumbs overlay banner-bread">
        <div class="container">
            <div class="bread-inner">
                <div class="row">
                    <div class="col-12">
                        <h2>Đội ngũ chuyên gia</h2>
                        <ul class="bread-list">
                            <li><a href="/">Trang chủ</a></li>
                            <li><i class="icofont-simple-right"></i></li>
                            <li class="active">{{ $title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <img src="/user/assets/img/section-img.png" alt="#" />
                        <p>
                            Chúng tôi cung cấp các dịch vụ tốt nhất, giá cả hợp lý nhất và an toàn nhất. Quý khách hàng sẽ
                            luôn nhận được những dịch vụ tuyệt nhất.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                @if ($doctors)
                    @foreach ($doctors as $doctor)
                        <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <a href="{{ route('user.doctor-detail', $doctor->slug) }}">
                                <div class="team-item position-relative rounded overflow-hidden">
                                    <div class="overflow-hidden">
                                        <img class="img-fluid img-doctor"
                                            src="{{ $doctor->avatar ?? '/uploads/avatars/no-image.jpg' }}"
                                            alt="website template image" />
                                    </div>
                                    <div class="team-text bg-light-second text-center p-4">
                                        <h5>Bs {{ $doctor->name }}</h5>
                                        <p class="text-bg-dark">{{ $doctor->department->name ?? $doctor->clinic->name }}</p>
                                        <div class="team-social text-center">
                                            <a class="btnn btnn-square" href="/"><i class="icofont-facebook"></i></a>
                                            <a class="btnn btnn-square" href="mailto:{{ $doctor->email }}"><i
                                                    class="icofont-google-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
