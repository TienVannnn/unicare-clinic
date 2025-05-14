@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title fw-semibold"> <a href="{{ route('medical-certificate.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>Thêm mới giấy khám bệnh</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('medical-certificate.store') }}" method="POSt">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="patient_id" class="form-label">Bệnh nhân <span class="text-danger">*</span></label>
                            <select class="form-control tag-select"id="patient_id" name="patient_id">
                                <option value="" selected>Chọn bệnh nhận</option>
                                @if (!empty($patients))
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('patient_id')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="" class="form-label">BHYT</label>
                            <div style="margin-top: 10px">
                                <input type="checkbox" name="insurance" id="insurance">
                                <label for="insurance">Miễn phí 1 phần dịch vụ khám</label>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="clinic_id" class="form-label">Phòng khám <span class="text-danger">*</span></label>
                            <select class="form-control tag-select2" id="clinic_id" name="clinic_id">
                                <option value="" selected>Chọn phòng khám</option>
                                @if (!empty($clinics))
                                    @foreach ($clinics as $clinic)
                                        <option value="{{ $clinic->id }}">{{ $clinic->clinic_code }} - {{ $clinic->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('clinic_id')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/select2.css') }}">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $(".tag-select").select2({
                placeholder: "Chọn bệnh nhân",
            });
            $(".tag-select2").select2({
                placeholder: "Chọn phòng khám",
            });
        });
    </script>
@endsection
