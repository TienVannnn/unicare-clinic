@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('news.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa tin tức</span>
                    <span class="text-primary">"{{ $news->title }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $news->title }}"
                                class="form-control @error('title') is-invalid @enderror" id="title" name="title">
                            @error('title')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select class="form-control tag-select" multiple="multiple" id="category_id"
                                name="news_categories[]">
                                @if (!empty($categories))
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @if (isset($news) && $news->newsCategories->contains($category->id)) selected @endif>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('news_categories')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="thumbnail" class="form-label">Ảnh</label>
                            <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                            @if ($news->thumbnail)
                                <img src="{{ $news->thumbnail }}" alt="" height="50" width="50">
                            @endif
                            @error('thumbnail')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                            <select name="status" id="" class="form-select">
                                <option value="1" {{ $news->status === 1 ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ $news->status === 0 ? 'selected' : '' }}>Ẩn</option>
                            </select>
                            @error('status')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Nội dung <span class="text-danger">*</span></label>
                            <textarea name="content" id="content">{{ $news->content }}</textarea>
                            @error('content')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/select2.css') }}">
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' />
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'>
    </script>
    <script>
        $(function() {
            $('.tag-select').select2({
                placeholder: "Chọn danh mục"
            })
            new FroalaEditor('#content', {
                placeholderText: 'Nhập nội dung'
            });
        })
    </script>
@endsection
