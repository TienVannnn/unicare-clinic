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
        if (request()->filled('status')) {
            $statuses = ['0' => 'Chưa thanh toán', '1' => 'Đã thanh toán'];
            $filters[] = 'Trạng thái: <strong>' . ($statuses[request('status')] ?? 'Không rõ') . '</strong>';
        }
    @endphp
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (count($filters))
                    Tìm kiếm đơn thuốc
                @else
                    Danh sách đơn thuốc
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('prescription.index') }}">Quản
                    lý đơn thuốc</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                    <div class="search-container" title="Tìm kiếm đơn thuốc">
                        <form action="{{ route('admin.search', ['type' => 'prescription']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}"
                                title="Tìm kiếm theo từ khóa">
                            <select name="status" title="Tìm kiếm theo trạng thái">
                                <option value="">Trạng thái</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Chưa thanh toán
                                </option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đã thanh toán
                                </option>
                            </select>
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                    @can('them-don-thuoc')
                        <div class="d-flex justify-content-end my-2 align-items-center">
                            <a href="{{ route('prescriptions.export') }}"
                                class="btn btn-label-success btn-round btn-sm me-2">Excel</a>
                            <a href="{{ route('prescription.create') }}" class="btn btn-secondary"><i
                                    class="fas fa-plus me-1"></i>
                                Thêm đơn thuốc</a>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if (count($filters))
                    <p class="alert alert-info">
                        Kết quả tìm kiếm: {!! implode(', ', $filters) !!}
                    </p>
                @endif
                @if ($prescriptions->count() > 0)
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã</th>
                                    <th scope="col">Giấy khám bệnh</th>
                                    <th scope="col">Bệnh nhân</th>
                                    <th scope="col">Bác sĩ</th>
                                    <th scope="col">Tổng tiền (VNĐ)</th>
                                    <th scope="col">Trạng thái</th>
                                    @can(['chinh-sua-don-thuoc', 'xoa-don-thuoc'])
                                        <th scope="col">Hành động</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prescriptions as $key => $prescription)
                                    <tr>
                                        <td>{{ $prescriptions->firstItem() + $key }}</td>
                                        <td>{{ $prescription->prescription_code }}</td>
                                        <td><a href="{{ route('medical-certificate.show', $prescription->medical_certificate->id) }}"
                                                target="_blank">{{ $prescription->medical_certificate->medical_certificate_code }}</a>
                                        </td>
                                        <td>{{ $prescription->medical_certificate->patient->name ?? 'Lỗi' }}</td>
                                        <td>{{ $prescription->doctor->name }}</td>
                                        <td>{{ number_format($prescription->total_payment, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($prescription->status == 1)
                                                <span class="badge bg-success"><i class="fas fa-check me-1"></i>Đã thanh
                                                    toán</span>
                                            @else
                                                <span class="badge bg-warning"><i class="fa fa-info me-1"></i>Chưa thanh
                                                    toán</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                @can('xac-nhan-thanh-toan')
                                                    @if ($prescription->status !== 1)
                                                        <form action="{{ route('prescription.pay', $prescription->id) }}"
                                                            method="POST" class="pay-form">
                                                            @csrf
                                                            <button type="button"
                                                                class="btn btn-outline-success btn-xs pay-btn me-2"
                                                                title="Xác nhận thanh toán" data-id="{{ $prescription->id }}">
                                                                <i class="fas fa-check" data-bs-toggle="tooltip"
                                                                    title="Xác nhận thanh toán"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endcan
                                                <a href="{{ route('prescription.show', $prescription->id) }}"
                                                    class="btn btn-outline-success btn-xs me-2" title="Xem đơn thuốc"><i
                                                        class="icon-eye" data-bs-toggle="tooltip"
                                                        title="Xem đơn thuốc"></i></a>
                                                @can('chinh-sua-don-thuoc')
                                                    @if ($prescription->status !== 1)
                                                        <a href="{{ route('prescription.edit', $prescription->id) }}"
                                                            class="btn btn-outline-primary btn-xs me-2" title="Chỉnh sửa"><i
                                                                class="fas fa-edit" data-bs-toggle="tooltip"
                                                                title="Chỉnh sửa"></i></a>
                                                    @endif
                                                @endcan
                                                <a href="{{ route('prescription.print', $prescription->id) }}"
                                                    target="_blank" class="btn btn-outline-success btn-xs me-2"
                                                    title="In đơn thuốc">
                                                    <i class="icon-printer" data-bs-toggle="tooltip"
                                                        title="In đơn thuốc"></i>
                                                </a>
                                                @can('xoa-don-thuoc')
                                                    <form action="{{ route('prescription.destroy', $prescription->id) }}"
                                                        method="POST" class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Xóa"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa"></i></button>
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
                    <p class="alert alert-danger">Chưa có đơn thuốc nào!</p>
                @endif
            </div>
            <div class="d-flex justify-content-center ">
                {{ $prescriptions->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
    <script src="{{ asset('admin-assets/js/custom/payment.js') }}"></script>
@endsection
