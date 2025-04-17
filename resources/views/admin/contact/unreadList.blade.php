@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    @php
        use Carbon\Carbon;
        $filters = [];
        if (request()->filled('q')) {
            $filters[] = 'Từ khóa: <strong>' . e(request('q')) . '</strong>';
        }
        if (request()->filled('date')) {
            $dateFormatted = \Carbon\Carbon::createFromFormat('Y-m-d', request('date'))->format('d/m/Y');
            $filters[] = 'Ngày: <strong>' . $dateFormatted . '</strong>';
        }
        if (request()->filled('filter_mode')) {
            $mode = request('filter_mode');
            $label = match ($mode) {
                'today' => 'Hôm nay',
                'this_week' => 'Tuần này',
                'this_month' => 'Tháng này',
                'this_year' => 'Năm nay',
                default => null,
            };
            if ($label) {
                $filters[] = 'Chế độ lọc: <strong>' . $label . '</strong>';
            }
        }
        if (request()->filled('status')) {
            if (request('status') == 1) {
                $statusText = 'Đã xem';
            } elseif (request('status') == 0) {
                $statusText = 'Chưa xem';
            } else {
                $statusText = 'Đã phản hồi';
            }
            $filters[] = 'Trạng thái: <strong>' . $statusText . '</strong>';
        }
    @endphp
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (count($filters))
                    Tìm kiếm liên hệ
                @else
                    Danh sách tin nhắn chưa đọc
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('contact.index') }}">Quản
                    lý liên hệ</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="search-container" title="Tìm kiếm liên hệ">
                        <form action="{{ route('admin.search', ['type' => 'contact']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}"
                                title="Tìm kiếm theo từ khóa">
                            <input type="date" name="date" value="{{ request('date') }}" title="Tìm kiếm theo ngày">
                            <select name="status" title="Tìm kiếm theo trạng thái">
                                <option value="">Trạng thái</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đã xem</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Chưa xem</option>
                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đã phản hồi</option>
                            </select>
                            <select name="filter_mode" title="Tìm kiếm theo ngày">
                                <option value="">Chọn chế độ</option>
                                <option value="today" {{ request('filter_mode') == 'today' ? 'selected' : '' }}>Hôm nay
                                </option>
                                <option value="this_week" {{ request('filter_mode') == 'this_week' ? 'selected' : '' }}>
                                    Tuần này
                                </option>
                                <option value="this_month" {{ request('filter_mode') == 'this_month' ? 'selected' : '' }}>
                                    Tháng này
                                </option>
                                <option value="this_year" {{ request('filter_mode') == 'this_year' ? 'selected' : '' }}>
                                    Năm
                                    này
                                </option>
                            </select>
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-end my-2">
                    <button id="mark-read-btn" class="btn btn-success btn-sm d-none"><i
                            class="fas fa-envelope-open me-2"></i>Đánh dấu đã đọc</button>
                    @can('xoa-lien-he')
                        <button id="delete-selected-btn" class="btn btn-danger btn-sm d-none">Xóa</button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if (count($filters))
                    <p class="alert alert-info">
                        Kết quả tìm kiếm: {!! implode(', ', $filters) !!}
                    </p>
                @endif
                @if ($contacts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th scope="col">Người gửi</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Thời gian</th>
                                    <th scope="col">Xử lý</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    <tr class="{{ $contact->status == 0 ? 'fw-bold text-black' : '' }}">
                                        <td><input type="checkbox" class="contact-checkbox" value="{{ $contact->id }}"
                                                data-status="{{ $contact->status }}">
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
                                                        class="btn btn-xs me-2 btn-danger" title="Đánh dấu là đã đọc"><i
                                                            class="fas fa-envelope-open" data-bs-toggle="tooltip"
                                                            title="Đánh dấu là đã đọc"></i></a>
                                                @elseif($contact->status == 1)
                                                    <a href="{{ route('contact.markRead', $contact->id) }}"
                                                        class="btn btn-xs me-2 btn-success" title="Đánh dấu là chưa đọc"><i
                                                            class="fa fa-envelope" data-bs-toggle="tooltip"
                                                            title="Đánh dấu là chưa đọc"></i></a>
                                                @endif
                                                @can('xem-chi-tiet-lien-he')
                                                    <a href="{{ route('contact.show', $contact->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2"
                                                        title="Xem tin nhắn liên hệ"><i class="fas fa-eye"
                                                            data-bs-toggle="tooltip" title="Xem tin nhắn liên hệ"></i></a>
                                                @endcan
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
                    <p class="alert alert-danger">Chưa có liên hệ nào!</p>
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
