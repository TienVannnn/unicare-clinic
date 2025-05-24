@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    @php
        $filters = [];
        if (request()->filled('q')) {
            $filters[] = 'Từ khóa: <strong>' . e(request('q')) . '</strong>';
        }
    @endphp
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (count($filters))
                    Tìm kiếm lô thuốc
                @else
                    {{ $title }}
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('medicine.index') }}">Quản lý thuốc</a> / <a href="{{ route('medicine-batch.index') }}">Quản
                    lý lô thuốc</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="search-container" title="Tìm kiếm lô thuốc">
                        <form action="{{ route('admin.search', ['type' => 'medicine-batch']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                    @if (empty($medicine))
                        <div class="d-flex justify-content-end my-2 align-items-center">
                            <a href="{{ route('medicine-batches.export') }}"
                                class="btn btn-label-success btn-round btn-sm me-2">Excel</a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if (count($filters))
                    <p class="alert alert-info">
                        Kết quả tìm kiếm: {!! implode(', ', $filters) !!}
                    </p>
                @endif
                @if ($batchs->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Lô thuốc</th>
                                    <th scope="col">Tên thuốc</th>
                                    <th scope="col">Nhà sản xuất</th>
                                    <th scope="col">Ngày sản xuất</th>
                                    <th scope="col">Ngày hết hạn</th>
                                    <th scope="col">Số lượng nhập vào</th>
                                    <th scope="col">Giá nhập</th>
                                    <th scope="col">Thuốc tồn</th>
                                    @can(['chinh-sua-thuoc', 'xoa-thuoc'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($batchs as $key => $batch)
                                    <tr>
                                        <td>{{ $batchs->firstItem() + $key }}</td>
                                        <td>{{ $batch->batch_number }}</td>
                                        <td>{{ $batch->medicine->name }}</td>
                                        <td>{{ $batch->manufacturer }}</td>
                                        <td>{{ $batch->manufacture_date }}</td>
                                        <td>{{ $batch->expiry_date }}</td>
                                        <td>{{ $batch->quantity_received }}</td>
                                        <td>{{ number_format($batch->purchase_price, 0, ',', '.') }}</td>
                                        <td>{{ $batch->total_quantity }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-thuoc')
                                                    <a href="{{ route('medicine-batch.edit', $batch->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa lô thuốc"></i></a>
                                                @endcan
                                                @can('xoa-thuoc')
                                                    <form action="{{ route('medicine-batch.destroy', $batch->id) }}"
                                                        method="POST" class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa lô thuốc"></i></button>
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
                    <p class="alert alert-danger">Chưa có lô thuốc nào!</p>
                @endif
            </div>
            <div class="d-flex justify-content-center ">
                {{ $batchs->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
