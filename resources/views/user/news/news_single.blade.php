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
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="main-sidebar">
                        <div class="single-widget category">
                            <h3 class="title">Danh mục tin tức</h3>
                            <ul class="categor-list">
                                <li><a href="#">Men's Apparel</a></li>
                                <li><a href="#">Women's Apparel</a></li>
                                <li><a href="#">Bags Collection</a></li>
                                <li><a href="#">Accessories</a></li>
                                <li><a href="#">Sun Glasses</a></li>
                            </ul>
                        </div>
                        <div class="single-widget recent-post">
                            <h3 class="title">Recent post</h3>
                            <div class="single-post">
                                <div class="image">
                                    <img src="img/blog-sidebar1.jpg" alt="#" />
                                </div>
                                <div class="content">
                                    <h5><a href="#">We have annnocuced our new product.</a></h5>
                                    <ul class="comment">
                                        <li>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>Jan 11,
                                            2020
                                        </li>
                                        <li>
                                            <i class="fa fa-commenting-o" aria-hidden="true"></i>35
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="single-post">
                                <div class="image">
                                    <img src="img/blog-sidebar2.jpg" alt="#" />
                                </div>
                                <div class="content">
                                    <h5>
                                        <a href="#">Top five way for solving teeth problems.</a>
                                    </h5>
                                    <ul class="comment">
                                        <li>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>Mar 05,
                                            2019
                                        </li>
                                        <li>
                                            <i class="fa fa-commenting-o" aria-hidden="true"></i>59
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="single-post">
                                <div class="image">
                                    <img src="img/blog-sidebar3.jpg" alt="#" />
                                </div>
                                <div class="content">
                                    <h5>
                                        <a href="#">We provide highly business soliutions.</a>
                                    </h5>
                                    <ul class="comment">
                                        <li>
                                            <i class="fa fa-calendar" aria-hidden="true"></i>June
                                            09, 2019
                                        </li>
                                        <li>
                                            <i class="fa fa-commenting-o" aria-hidden="true"></i>44
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Single News -->
@endsection
