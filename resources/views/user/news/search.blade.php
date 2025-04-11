@extends('user.layout.main')

@section('content')
    <div class="breadcrumbs overlay banner-bread">
        <div class="container">
            <div class="bread-inner">
                <div class="row">
                    <div class="col-12">
                        <h2>Tin tức</h2>
                        <ul class="bread-list">
                            <li><a href="/">Trang chủ</a></li>
                            <li><i class="icofont-simple-right"></i></li>
                            <li class="active">Tìm kiếm</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="blog" id="blog" style="padding: 20px 0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <img src="/user/assets/img/section-img.png" alt="#" />
                        <h4 class="text-uppercase">
                            Kết quả tìm kiếm với từ khóa: <span style="color: #f05a28">"{{ request('q') }}"</span>
                        </h4>
                    </div>
                </div>
            </div>
            @if ($news->isNotEmpty())
                <div class="row">
                    @foreach ($news as $new)
                        @php
                            $firstCategory = $new->newsCategories->first();
                        @endphp
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
                                            <a
                                                href="{{ route('user.news-detail', ['slugCategory' => $firstCategory->slug, 'slug' => $new->slug]) }}">
                                                {{ Str::words($new->title, 12, '...') }}</a>
                                        </h2>
                                        <p class="text">
                                            {!! Str::limit(strip_tags($new->content), 150, '...') !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center">
                    {{ $news->links() }}
                </div>
            @else
                <div class="w-100">
                    <p class="text-danger text-center">Không có bài viết nào có từ khóa:
                        <span class="font-weight-bold"> "{{ request('q') }}"</span>
                    </p>
                </div>
            @endif

        </div>
    </section>
@endsection
