@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title fw-semibold"> <a href="{{ route('manager.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>Thêm mới nhân viên</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('manager.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên nhân viên <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Nhập tên nhân viên" value="{{ old('name') }}">
                            @error('name')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="Nhập email" value="{{ old('email') }}">
                            @error('email')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="clinic" class="form-label">Chuyên khoa <span class="text-danger">*</span></label>
                            <select class="form-control tag-select3" id="department" name="department">
                                <option value="" selected>Chọn chuyên khoa</option>
                                @if (!empty($departments))
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}
                                            ({{ $department->clinics->count() }} phòng khám)
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('department')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="clinic" class="form-label">Phòng ban <span class="text-danger">*</span></label>
                            <select class="form-control tag-select2" id="clinic" name="clinic">
                                <option value="" selected>Chọn phòng ban</option>
                                @if (!empty($clinics))
                                    @foreach ($clinics as $clinic)
                                        <option value="{{ $clinic->id }}">{{ $clinic->clinic_code }} -
                                            {{ $clinic->name }}
                                            @if (!empty($clinic->role_summary))
                                                (@foreach ($clinic->role_summary as $role => $count)
                                                    {{ $role }}: {{ $count }}{{ !$loop->last ? ',' : '' }}
                                                @endforeach)
                                            @else
                                                (Không có nhân viên)
                                            @endif
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('clinic')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="role" class="form-label">Vai trò <span class="text-danger">*</span></label>
                            <select class="form-control tag-select" multiple="multiple" id="role" name="role[]">
                                @if (!empty($roles))
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">
                                            {{ $role->name }} ({{ $role->users->count() }} người)</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('role')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status">
                                <option value="1" selected>Hoạt động</option>
                                <option value="0">Khóa</option>
                            </select>
                            @error('status')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
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
    <script src="{{ asset('admin-assets/js/custom/admin.js') }}"></script>
@endsection
