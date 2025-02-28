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
                            <li class="active">Tin tức</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="blog section" id="blog">
        <div class="container">
            <div class="row">
                @if ($news->isNotEmpty())
                    @foreach ($news as $new)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-news">
                                <div class="news-head">
                                    <img src="{{ $new->thumbnail }}" alt="#" />
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
@endsection
