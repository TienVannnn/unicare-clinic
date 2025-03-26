@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                <a href="{{ route('patient.index') }}">Danh sách bệnh nhân</a> / Lịch sử khám bệnh
            </div>
            <div class="fw-bold text-capitalize">
                {{ $patient->name }} - {{ \Carbon\Carbon::parse($patient->dob)->format('d/m/Y') }}
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="search-container">
                        <form action="{{ route('admin.search', ['type' => 'patient']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tên bệnh nhân" name="name">
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">

                @if ($medical_history->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table ">
                            <thead class="table-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Ngày khám</th>
                                    <th>Bác sĩ</th>
                                    <th>Chẩn đoán</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($medical_history as $key => $his)
                                    <tr>
                                        <td>{{ $medical_history->firstItem() + $key }}</td>
                                        <td>{{ $his->created_at->format('H:i d:m:Y') }}</td>
                                        <td>BS. {{ $his->doctor->name }}</td>
                                        <td>{!! $his->diagnosis !!}</td>
                                        <td><a href="{{ route('medical-certificate.show', $his->id) }}"
                                                class="btn btn-info btn-sm">Xem chi tiết</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    Bệnh nhân này chưa có hồ sơ khám nào!
                @endif
            </div>
        </div>
    </div>
@endsection
