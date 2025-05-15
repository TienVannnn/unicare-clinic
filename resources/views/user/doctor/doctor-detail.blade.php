@extends('user.layout.main')

@section('content')
    <div class="breadcrumbs overlay banner-bread">
        <div class="container">
            <div class="bread-inner">
                <div class="row">
                    <div class="col-12">
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
                <div class="col-md-6">
                    <img src="{{ $doctor->avatar }}" alt="{{ $doctor->name }}">
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 style="color: #f05a28">Bs {{ $doctor->name }}</h2>
                            <p class="font-weight-bold" style="color: black">Chuyên khoa: {{ $doctor->department->name }}
                            </p>
                        </div>
                        <div class="get-quote mt-0  ">
                            <a href="{{ route('user.book-appointment-page', ['doctor_id' => $doctor->id]) }}"
                                class="btn">ĐẶT LỊCH</a>
                        </div>
                    </div>
                    <div class="phoneAndMailDoctor"><a href="tel:{{ $doctor->phone ?? '082.234.5959' }}"
                            title="(0258) 3871 134"><span class="iconContactDoctor"><svg aria-hidden="true"
                                    focusable="false" data-prefix="fas" data-icon="phone" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                    class="svg-inline--fa fa-phone fa-w-16 fa-3x">
                                    <path fill="currentColor"
                                        d="M493.4 24.6l-104-24c-11.3-2.6-22.9 3.3-27.5 13.9l-48 112c-4.2 9.8-1.4 21.3 6.9 28l60.6 49.6c-36 76.7-98.9 140.5-177.2 177.2l-49.6-60.6c-6.8-8.3-18.2-11.1-28-6.9l-112 48C3.9 366.5-2 378.1.6 389.4l24 104C27.1 504.2 36.7 512 48 512c256.1 0 464-207.5 464-464 0-11.2-7.7-20.9-18.6-23.4z">
                                    </path>
                                </svg></span>{{ $doctor->phone ?? '082.234.5959' }}</a><a href="mailto:{{ $doctor->email }}"
                            title="info@unicaremedic.vn"><span class="iconContactDoctor"><svg aria-hidden="true"
                                    focusable="false" data-prefix="fas" data-icon="envelope" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                    class="svg-inline--fa fa-envelope fa-w-16 fa-3x">
                                    <path fill="currentColor"
                                        d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.6 21.1 15.4 56.7 47.8 92.2 47.6 35.7.3 72-32.8 92.3-47.6 102-74.1 131.6-96.3 154-113.7zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z">
                                    </path>
                                </svg></span>{{ $doctor->email }}</a>
                    </div>
                    <div class="my-2">
                        <p class="font-weight-bold">Thời gian làm việc</p>
                        <p>Từ thứ Hai đến thứ Sáu: {{ $doctor->schedule->morning_start }} -
                            {{ $doctor->schedule->morning_end }} ; {{ $doctor->schedule->afternoon_start }} -
                            {{ $doctor->schedule->afternoon_end }} </p>
                    </div>
                    <div>
                        <h3 style="color: #f05a28">CHI TIẾT</h2>
                            <p class="font-weight-bold">Kinh nghiệm làm việc</p>
                            <p>{{ $manager->experience ?? 'Chưa cập nhật kinh nghiệm' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('user/assets/css/custom/doctor-detail.css') }}">
@endsection
