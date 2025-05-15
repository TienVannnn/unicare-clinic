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
    <section class="news-single section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <thead style="background-color: #f05a28; color: white">
                                    <tr>
                                        <th scope="col">STT</th>
                                        <th scope="col">Dịch vụ
                                        </th>
                                        <th scope="col">Giá dịch vụ (VNĐ)</th>
                                        <th scope="col">Giá BHYT (VNĐ)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medical_services as $key => $service)
                                        <tr>
                                            <td>{{ $medical_services->firstItem() + $key }}</td>
                                            <td>{{ $service->name }}</td>
                                            <td>{{ number_format($service->price, 0, ',', '.') }}</td>
                                            <td>{{ number_format($service->insurance_price, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $medical_services->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="main-sidebar mt-md-0" style="margin-top: 100px">
                        <div class="single-widget recent-post">
                            <h3 class="title">Tin mới</h3>
                            @foreach ($news as $blog)
                                <div class="single-post">
                                    <div class="image">
                                        <img src="{{ $blog->thumbnail }}" alt="#" />
                                    </div>
                                    <div class="content">
                                        <h5><a
                                                href="{{ route('user.news-detail', ['slugCategory' => $blog->newsCategories->first()->slug, 'slug' => $blog->slug]) }}">{{ $blog->title }}</a>
                                        </h5>
                                        <ul class="comment">
                                            <li>
                                                <i class="fa fa-calendar"
                                                    aria-hidden="true"></i>{{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Single News -->
@endsection
@section('css')
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            color: black
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
@endsection
