@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/select2.css') }}">
@endsection

@section('content')

    <div class="container">
        <div class="d-flex justify-content-start align-items-center m-4">
            <div class="fw-bold text-capitalize">
                <a href="{{ route('menu.index') }}">Quản lý menu</a> / <a
                    href="{{ route('menu.show', $menu->id) }}">{{ $menu->name }}</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                @if ($menu->items->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên mục</th>
                                    <th scope="col">Đường dẫn liên kết</th>
                                    @can(['sua-menu', 'xoa-menu'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menu->items as $key => $menu_item)
                                    @if ($menu_item->parent_id == null)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><a
                                                    href="{{ route('admin.menu_items', [$menu->id, $menu_item->id]) }}">{{ $menu_item->title }}</a>
                                                @if ($menu_item->children->count() > 0)
                                                    ({{ $menu_item->children->count() }} menu con)
                                                @endif
                                            </td>
                                            <td>
                                                {{ $menu_item->url }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @can('sua-menu')
                                                        <a href="{{ route('admin.edit-menu-item', [$menu->id, $menu_item->id]) }}"
                                                            class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                                class="fas fa-edit" data-bs-toggle="tooltip"
                                                                title="Chỉnh sửa menu"></i></a>
                                                    @endcan
                                                    @can('xoa-menu')
                                                        <form action="{{ route('admin.menu_item.destroy', $menu_item->id) }}"
                                                            method="POST" class="delete-form">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="button" title="Delete"
                                                                class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                    class="fas fa-trash" data-bs-toggle="tooltip"
                                                                    title="Xóa menu"></i></button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="alert alert-danger">Chưa có menu trực thuộc nào!</p>
                @endif
            </div>
            <div class="card-body">
                <p>{{ isset($editItem) ? 'Chỉnh sửa mục menu' : 'Thêm mục cho menu' }}</p>
                <form
                    action="{{ isset($editItem) ? route('admin.menu.update-item', $editItem->id) : route('admin.menu.create-item') }}"
                    method="POST">
                    @csrf
                    @if (isset($editItem))
                        @method('PUT')
                    @endif
                    <input type="text" name="menu_id" class="d-none" value="{{ $menu->id }}">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Thuộc mục <span class="text-danger">*</span></label>
                        <select class="form-control tag-select" id="parent_id" name="parent_id">
                            <option value="">Là mục chính</option>
                            @foreach ($menu->items as $menu_parent)
                                @if ($menu_parent->parent_id == null)
                                    <option value="{{ $menu_parent->id }}"
                                        @if (isset($editItem)) {{ $menu_parent->id == $editItem->id ? 'disabled' : '' }} @endif>
                                        {{ $menu_parent->title }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('parent_id')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Liên kết đến module </label>
                        <select class="form-control tag-select2" id="module" name="module">
                            <option value="">Chọn module</option>
                            @foreach ($modules as $module)
                                <option value="{{ $module->id }}" data-title="{{ $module->name }}"
                                    data-url="{{ $module->slug }}">
                                    {{ $module->name }}</option>
                            @endforeach
                        </select>
                        @error('module')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Tên mục <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" placeholder="Nhập tên mục"
                            value="{{ isset($editItem) ? $editItem->title : old('title') }}">

                        @error('title')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Đường dẫn liên kết <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('url') is-invalid @enderror" id="url"
                            name="url" placeholder="Nhập đường dẫn"
                            value="{{ isset($editItem) ? $editItem->url : old('url') }}">

                        @error('url')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($editItem) ? 'Cập nhật' : 'Lưu lại' }}
                    </button>

                </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
    <script>
        $(function() {
            $('.tag-select').select2({
                placeholder: "Là mục chính",
                allowClear: true,
            })
            $(".tag-select2").select2({
                placeholder: "Chọn module",
            }).on('change', function() {
                var selected = $(this).find('option:selected');
                var title = selected.data('title');
                var url = selected.data('url');

                if (title) {
                    $('#title').val(title);
                }

                if (url) {
                    $('#url').val(url);
                }
            });
        })
    </script>
@endsection
