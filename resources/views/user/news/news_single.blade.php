@extends('user.layout.main')
@section('content')
    <div class="breadcrumbs overlay banner-bread">
        <div class="container">
            <div class="bread-inner">
                <div class="row">
                    <div class="col-12">
                        <h2>Chi tiết bài viết</h2>
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
                            <div class="single-main">
                                <div class="news-head">
                                    <img src="{{ $blog->thumbnail }}" alt="#" />
                                    {!! $blog->content !!}
                                </div>
                            </div>
                            <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-width=""
                                data-layout="" data-action="" data-size="" data-share="true"></div>
                            <div class="fb-comments" data-href="{{ \URL::current() }}" data-width="100%" data-numposts="10">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="main-sidebar">
                        <div class="single-widget category">
                            <h3 class="title">Danh mục tin tức</h3>
                            <ul class="categor-list">
                                @foreach ($categories as $cate)
                                    <li><a href="{{ route('user.news', $cate->slug) }}">{{ $cate->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="single-widget recent-post">
                            <h3 class="title">Tin tức liên quan</h3>
                            @foreach ($relatedNews as $blog)
                                <div class="single-post">
                                    <div class="image">
                                        <img src="{{ $blog->thumbnail }}" alt="#" />
                                    </div>
                                    <div class="content">
                                        <h5><a
                                                href="{{ route('user.news-detail', ['slugCategory' => $category->slug, 'slug' => $blog->slug]) }}">{{ $blog->title }}</a>
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

@section('js')
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v22.0">
    </script>
@endsection
