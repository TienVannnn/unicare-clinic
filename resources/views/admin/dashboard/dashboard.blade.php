@extends('admin.layout_admin.main')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Trang quản trị</h3>
                    <h6 class="op-7 mb-2">Chào mừng bạn quay trở lại</h6>
                </div>
            </div>
            <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <label for="from_date" class="form-label">Từ ngày</label>
                        <input type="date" id="from_date" name="from_date" class="form-control"
                            value="{{ request('from_date') }}">
                        @error('from_date')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mt-md-0 mt-3">
                        <label for="to_date" class="form-label">Đến ngày</label>
                        <input type="date" id="to_date" name="to_date" class="form-control"
                            value="{{ request('to_date') }}">
                        @error('to_date')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3 mt-md-0 mt-3">
                        <label for="filter_mode" class="form-label">Chế độ lọc</label>
                        <select id="filter_mode" name="filter_mode" class="form-control">
                            <option value="">-- Chọn chế độ --</option>
                            <option value="today" {{ request('filter_mode') == 'today' ? 'selected' : '' }}>Hôm nay
                            </option>
                            <option value="this_week" {{ request('filter_mode') == 'this_week' ? 'selected' : '' }}>Tuần này
                            </option>
                            <option value="this_month" {{ request('filter_mode') == 'this_month' ? 'selected' : '' }}>Tháng
                                này</option>
                            <option value="this_year" {{ request('filter_mode') == 'this_year' ? 'selected' : '' }}>Năm này
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end mt-md-0 mt-3">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Bệnh nhân</p>
                                        <h4 class="card-title">{{ $patients }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Lịch hẹn khám</p>
                                        <h4 class="card-title">{{ $appointments }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-luggage-cart"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Doanh thu</p>
                                        <h4 class="card-title">{{ number_format($totalRevenue) }} VNĐ</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                        <i class="far fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Giấy khám bệnh</p>
                                        <h4 class="card-title">{{ $medical_certificates }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6"><canvas id="chartBenhNhan"></canvas></div>
                <div class="col-md-6"><canvas id="chartDoanhThu"></canvas></div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6"><canvas id="chartDichVuPhobien"></canvas></div>
                <div class="col-md-6 "><canvas id="chartBenhNhanMoiCu"></canvas></div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        new Chart(document.getElementById('chartBenhNhan'), {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Bệnh nhân theo tháng',
                    data: @json($benhNhanData),
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });

        new Chart(document.getElementById('chartDoanhThu'), {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Doanh thu theo tháng',
                    data: @json($doanhThuData),
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            }
        });

        const dvLabels = @json(array_keys($dichVuPhobien->toArray()));
        const dvCounts = @json(array_values($dichVuPhobien->toArray()));

        new Chart(document.getElementById('chartDichVuPhobien'), {
            type: 'pie',
            data: {
                labels: dvLabels,
                datasets: [{
                    label: 'Tỷ lệ sử dụng dịch vụ',
                    data: dvCounts,
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#8BC34A',
                        '#FF9800'
                    ]
                }]
            },
        });

        new Chart(document.getElementById('chartBenhNhanMoiCu'), {
            type: 'pie',
            data: {
                labels: ['Bệnh nhân mới', 'Bệnh nhân quay lại'],
                datasets: [{
                    data: [{{ $benhNhanMoi }}, {{ $benhNhanCu }}],
                    backgroundColor: ['#4CAF50', '#FFC107']
                }]
            }
        });
    </script>
@endsection
