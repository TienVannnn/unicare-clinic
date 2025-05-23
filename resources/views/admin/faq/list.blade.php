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
        if (request()->filled('status')) {
            if (request('status') == 1) {
                $statusText = 'Đã trả lời';
            } elseif (request('status') == 0) {
                $statusText = 'Chưa trả lời';
            }
            $filters[] = 'Trạng thái: <strong>' . $statusText . '</strong>';
        }
    @endphp
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (count($filters))
                    Tìm kiếm câu hỏi
                @else
                    Danh sách câu hỏi
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('faq.index') }}">Quản
                    lý câu hỏi</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="search-container" title="Tìm kiếm câu hỏi">
                        <form action="{{ route('admin.search', ['type' => 'faq']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}"
                                title="Tìm kiếm theo từ khóa">
                            <input type="date" name="date" value="{{ request('date') }}" title="Tìm kiếm theo ngày">
                            <select name="status" title="Tìm kiếm theo trạng thái">
                                <option value="">Trạng thái</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Chưa trả lời
                                </option>
                                <option value="2" {{ request('status') == '1' ? 'selected' : '' }}>Đã trả lời</option>
                            </select>
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (count($filters))
                    <p class="alert alert-info">
                        Kết quả tìm kiếm: {!! implode(', ', $filters) !!}
                    </p>
                @endif
                @if ($faqs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>STT</th>
                                    <th scope="col">Người gửi</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Chuyên khoa</th>
                                    <th scope="col">Thời gian</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Xử lý</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $key => $faq)
                                    <tr class="{{ $faq->is_viewed == 0 ? 'fw-bold text-black' : '' }}">
                                        <td>{{ $faqs->firstItem() + $key }}</td>
                                        <td>{{ $faq->user->name }}</td>
                                        <td>{{ $faq->user->email }}</td>
                                        <td>{{ $faq->title }}</td>
                                        <td><span class="badge badge-primary">{{ $faq->department->name }}</span></td>
                                        <td>
                                            @php
                                                $diffInDays = $faq->created_at->diffInDays(now());
                                            @endphp
                                            {{ $diffInDays > 15 ? $faq->created_at->format('H:i d/m/Y') : $faq->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            @if (!$faq->answer)
                                                <span class="badge badge-danger">Chưa trả lời</span>
                                            @else
                                                <span class="badge badge-success"> Đã trả lời</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('xem-chi-tiet-lien-he')
                                                    <a href="{{ route('faq.show', $faq->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2"
                                                        title="Xem tin nhắn câu hỏi"><i class="far fa-comments"
                                                            data-bs-toggle="tooltip" title="Xem tin nhắn câu hỏi"></i></a>
                                                @endcan
                                                @can('xoa-lien-he')
                                                    <form action="{{ route('faq.destroy', $faq->id) }}" method="POST"
                                                        class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Xóa tin nhắn"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa câu hỏi"></i></button>
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
                    <p class="alert alert-danger">Chưa có câu hỏi nào!</p>
                @endif
            </div>

            <div class="d-flex justify-content-center ">
                {{ $faqs->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
