@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="search-container">
                        <form action="{{ route('admin.search', ['type' => 'contact']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tiêu đề liên hệ" name="name">
                        </form>
                    </div>
                    <div>
                        <button id="mark-read-btn" class="btn btn-success btn-sm d-none"><i
                                class="fas fa-envelope-open me-2"></i>Đánh dấu đã đọc</button>
                        <button id="delete-selected-btn" class="btn btn-danger btn-sm d-none">Xóa</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($contacts->count() > 0)
                    @if (request()->has('name') && request()->input('name') != '')
                        <p class="alert alert-info">
                            Kết quả tìm kiếm cho từ khóa: <strong>{{ request()->input('name') }}</strong>
                        </p>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th scope="col">Người gửi</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Thời gian</th>
                                    @can('xoa-lien-he')
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    <tr class="{{ $contact->status == 0 ? 'fw-bold text-black' : '' }}">
                                        <td><input type="checkbox" class="contact-checkbox" value="{{ $contact->id }}">
                                        </td>
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->title }}</td>
                                        <td>
                                            @php
                                                $diffInDays = $contact->created_at->diffInDays(now());
                                            @endphp
                                            {{ $diffInDays > 15 ? $contact->created_at->format('H:i d/m/Y') : $contact->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($contact->status == 0)
                                                    <a href="{{ route('contact.markRead', $contact->id) }}"
                                                        class="btn btn-xs me-2" title="Đánh dấu là đã đọc"><i
                                                            class="fas fa-envelope-open" data-bs-toggle="tooltip"
                                                            title="Đánh dấu là đã đọc"></i></a>
                                                @elseif($contact->status == 1)
                                                    <a href="{{ route('contact.markRead', $contact->id) }}"
                                                        class="btn btn-xs me-2" title="Đánh dấu là chưa đọc"><i
                                                            class="fa fa-envelope" data-bs-toggle="tooltip"
                                                            title="Đánh dấu là chưa đọc"></i></a>
                                                @endif
                                                <a href="{{ route('contact.show', $contact->id) }}"
                                                    class="btn btn-outline-primary btn-xs me-2"
                                                    title="Xem tin nhắn liên hệ"><i class="fas fa-eye"
                                                        data-bs-toggle="tooltip" title="Xem tin nhắn liên hệ"></i></a>
                                                @can('xoa-lien-he')
                                                    <form action="{{ route('contact.destroy', $contact->id) }}" method="POST"
                                                        class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Xóa tin nhắn"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa liên hệ"></i></button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    @if (request()->has('name') && request()->input('name') != '')
                        <p class="alert alert-danger">Không tìm thấy kết quả nào cho từ khóa
                            <strong>{{ request()->input('name') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có liên hệ nào!</p>
                    @endif
                @endif
            </div>

            <div class="d-flex justify-content-center ">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
    <script src="{{ asset('admin-assets/js/custom/contact-checkall.js') }}"></script>
@endsection
