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
                        <form action="{{ route('admin.search', ['type' => 'medical_certificate']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập mã giấy khám bệnh" name="name">
                        </form>
                    </div>
                    @can('them-giay-kham-benh')
                        <a href="{{ route('medical-certificate.create') }}" class="btn btn-secondary"><i
                                class="fas fa-plus me-1"></i>
                            Thêm giấy khám bệnh</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($medical_certificates->count() > 0)
                    @if (request()->has('name') && request()->input('name') != '')
                        <p class="alert alert-info">
                            Kết quả tìm kiếm cho từ khóa: <strong>{{ request()->input('name') }}</strong>
                        </p>
                    @endif
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã</th>
                                    <th scope="col">Bệnh nhân</th>
                                    <th scope="col">Bác sĩ</th>
                                    <th scope="col">Phòng khám</th>
                                    <th scope="col">Ngày</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Thanh toán</th>
                                    @can(['chinh-sua-giay-kham-benh', 'xoa-giay-kham-benh'])
                                        <th scope="col">Hành động</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medical_certificates as $key => $medical_certificate)
                                    <tr>
                                        <td>{{ $medical_certificates->firstItem() + $key }}</td>
                                        <td>{{ $medical_certificate->medical_certificate_code }}</td>
                                        <td>{{ $medical_certificate->patient->name }}</td>
                                        <td>{{ $medical_certificate->doctor->name ?? 'Chưa khám' }}</td>
                                        <td>{{ $medical_certificate->clinic->name }}</td>
                                        <td>{{ $medical_certificate->created_at->format('H:i d/m/Y') }}</td>
                                        <td>
                                            @if ($medical_certificate->medical_status === 0)
                                                <span class="badge bg-warning"></i>Chờ
                                                    khám</span>
                                            @elseif ($medical_certificate->medical_status === 1)
                                                <span class="badge bg-primary">Đang
                                                    khám</span>
                                            @elseif ($medical_certificate->medical_status === 2)
                                                <span class="badge bg-success"><i class="fas fa-check me-1"></i>Đã
                                                    khám</span>
                                            @else
                                                <span class="badge bg-danger"><i class="fa fa-info me-1"></i>Không xác
                                                    định</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($medical_certificate->payment_status === 0)
                                                <span class="badge bg-danger">Chưa thanh
                                                    toán</span>
                                            @elseif ($medical_certificate->payment_status === 1)
                                                <span class="badge bg-success"><i class="fas fa-check me-1"></i>Đã thanh
                                                    toán</span>
                                            @elseif ($medical_certificate->payment_status === 2)
                                                <span class="badge bg-warning"><i class="fas fa-check me-1"></i>Đã tạm
                                                    ứng</span>
                                            @else
                                                <span class="badge bg-danger"><i class="fa fa-info me-1"></i>Không xác
                                                    định</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center">
                                                @can('xac-nhan-thanh-toan')
                                                    @if ($medical_certificate->payment_status !== 1)
                                                        @if (
                                                            !$medical_certificate->medical_service_id ||
                                                                ($medical_certificate->medical_service_id && $medical_certificate->payment_status == 2))
                                                            <button type="button"
                                                                class="btn btn-outline-success btn-xs pay-btn me-2"
                                                                title="Xác nhận thanh toán"
                                                                data-id="{{ $medical_certificate->id }}">
                                                                <i class="fas fa-check" data-bs-toggle="tooltip"
                                                                    title="Xác nhận thanh toán"></i>
                                                            </button>
                                                        @elseif($medical_certificate->medical_service_id && $medical_certificate->payment_status == 0)
                                                            <button type="button"
                                                                class="btn btn-outline-warning btn-xs pay-advance-btn me-2"
                                                                title="Thu tiền tạm ứng"
                                                                data-id="{{ $medical_certificate->id }}">
                                                                <i class="fas fa-check-double" data-bs-toggle="tooltip"
                                                                    title="Thu tiền tạm ứng"></i>
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endcan
                                                @if ($medical_certificate->medical_service_id && $medical_certificate->payment_status != 1)
                                                    <a href="{{ route('medical-certificate.print-advance', $medical_certificate->id) }}"
                                                        target="_blank" class="btn btn-outline-warning btn-xs me-2"
                                                        title="In phiếu tạm ứng">
                                                        <i class="icon-printer" data-bs-toggle="tooltip"
                                                            title="In phiếu tạm ứng"></i>
                                                    </a>
                                                @endif
                                                <a href="{{ route('medical-certificate.show', $medical_certificate->id) }}"
                                                    class="btn btn-outline-success btn-xs me-2"
                                                    title="Xem giấy khám bệnh"><i class="icon-eye" data-bs-toggle="tooltip"
                                                        title="Xem giấy khám bệnh"></i></a>
                                                @can('chinh-sua-giay-kham-benh')
                                                    @if ($medical_certificate->medical_status === 0)
                                                        <a href="{{ route('medical-certificate.edit', $medical_certificate->id) }}"
                                                            class="btn btn-outline-primary btn-xs me-2" title="Chỉnh sửa"><i
                                                                class="fas fa-edit" data-bs-toggle="tooltip"
                                                                title="Chỉnh sửa"></i></a>
                                                    @endif
                                                @endcan
                                                @can('kham-benh')
                                                    @if ($medical_certificate->medical_status !== 2)
                                                        <a href="{{ route('medical-certificate.service', $medical_certificate->id) }}"
                                                            class="btn btn-outline-success btn-xs me-2" title="Khám dịch vụ">
                                                            <i class="fas fa-plus-circle" data-bs-toggle="tooltip"
                                                                title="Khám dịch vụ"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('medical-certificate.conclude', $medical_certificate->id) }}"
                                                        class="btn btn-outline-success btn-xs me-2" title="Kết luận khám">
                                                        <i class="fas fa-calendar-check" data-bs-toggle="tooltip"
                                                            title="Kết luận khám"></i>
                                                    </a>
                                                @endcan
                                                <a href="{{ route('medical-certificate.print', $medical_certificate->id) }}"
                                                    target="_blank" class="btn btn-outline-success btn-xs me-2"
                                                    title="In giấy khám bệnh">
                                                    <i class="icon-printer" data-bs-toggle="tooltip"
                                                        title="In giấy khám bệnh"></i>
                                                </a>
                                                @can('xoa-giay-kham-benh')
                                                    <form
                                                        action="{{ route('medical-certificate.destroy', $medical_certificate->id) }}"
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
                    @if (request()->has('name') && request()->input('name') != '')
                        <p class="alert alert-danger">Không tìm thấy giấy khám bệnh nào cho từ khóa
                            <strong>{{ request()->input('name') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có giấy khám bệnh nào!</p>
                    @endif
                @endif
            </div>
            <div class="d-flex justify-content-center ">
                {{ $medical_certificates->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
    <script src="{{ asset('admin-assets/js/custom/paymentCertificate.js') }}"></script>
@endsection
