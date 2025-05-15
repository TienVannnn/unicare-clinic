@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('manager.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa nhân viên</span>
                    <span class="text-primary">"{{ $manager->name }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('manager.update', $manager->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên nhân viên <span
                                    class="text-danger">*</span></label>
                            <input type="text" value="{{ $manager->name }}"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                aria-describedby="emailHelp" name="name">
                            @error('name')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $manager->email }}"
                                class="form-control @error('email') is-invalid @enderror" id="email"
                                aria-describedby="emailHelp" name="email">
                            @error('email')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <div class="form-group">
                                <label for="gender">Giới tính</label>
                                <div>
                                    <input type="radio" id="male" name="gender" value="1"
                                        @if ($manager->gender == 1) checked @endif>
                                    <label for="male">Nam</label>
                                    <input type="radio" id="female" name="gender" value="2"
                                        @if ($manager->gender == 2) checked @endif>
                                    <label for="female">Nữ</label>
                                </div>
                                @error('gender')
                                    <div class="message-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">Số điện thoại </label>
                            <input type="number" value="{{ $manager->phone }}" placeholder="Nhập số điện thoại"
                                class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
                            @error('phone')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="text" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Nhập mật khẩu">
                            @error('password')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="confirm" class="form-label">Xác nhận mật khẩu</label>
                            <input type="text" class="form-control" id="confirm" name="password_confirmation"
                                placeholder="Nhập xác nhận mật khẩu">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="clinic" class="form-label">Chuyên khoa <span class="text-danger">*</span></label>
                            <select class="form-control tag-select3" id="department" name="department">
                                <option value="" selected>Chọn chuyên khoa</option>
                                @if (!empty($departments))
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $department->id === $manager->department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
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
                            <select class="form-control tag-select2" id="clinic" name="clinic"
                                data-selected="{{ old('clinic', $manager->clinic_id ?? '') }}">
                                @if (!empty($clinics))
                                    @foreach ($clinics as $clinic)
                                        <option value="{{ $clinic->id }}"
                                            {{ $clinic->id === $manager->clinic->id ? 'selected' : '' }}>
                                            {{ $clinic->clinic_code }} -
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
                                        <option value="{{ $role->name }}"
                                            {{ in_array($role->id, $rolesChecked) ? 'selected' : '' }}>
                                            {{ $role->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Trạng thái <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status">
                                <option value="1" {{ $manager->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ $manager->status == 0 ? 'selected' : '' }}>Khóa</option>
                            </select>
                            @error('status')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" value="{{ $manager->address }}"
                                class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                placeholder="Nhập địa chỉ">
                            @error('address')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="avatar" class="form-label">Ảnh đại diện</label>
                            <input type="file" class="form-control" id="avatar" name="avatar">
                            @error('avatar')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                            @if ($manager->avatar)
                                <img src="{{ $manager->avatar }}" alt="" width="100">
                            @endif
                        </div>
                        <hr>
                        <h5 class="text-primary">Lịch làm việc (Thứ 2 đến Thứ 6)</h5>
                        <div class="row">
                            <div class="mb-3 col-md-3 col-sm-6">
                                <label for="morning_start" class="form-label">Bắt đầu sáng</label>
                                <input type="time" id="morning_start" name="morning_start" class="form-control"
                                    value="{{ $manager->schedule->morning_start ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-3 col-sm-6">
                                <label for="morning_end" class="form-label">Kết thúc sáng</label>
                                <input type="time" id="morning_end" name="morning_end" class="form-control"
                                    value="{{ $manager->schedule->morning_end ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-3 col-sm-6">
                                <label for="afternoon_start" class="form-label">Bắt đầu chiều</label>
                                <input type="time" id="afternoon_start" name="afternoon_start" class="form-control"
                                    value="{{ $manager->schedule->afternoon_start ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-3 col-sm-6">
                                <label for="afternoon_end" class="form-label">Kết thúc chiều</label>
                                <input type="time" id="afternoon_end" name="afternoon_end" class="form-control"
                                    value="{{ $manager->schedule->afternoon_end ?? '' }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="slot_duration" class="form-label">Thời lượng mỗi lượt (phút)</label>
                                <input type="number" id="slot_duration" name="slot_duration" class="form-control"
                                    value="{{ $manager->schedule->slot_duration ?? '' }}">
                            </div>
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
