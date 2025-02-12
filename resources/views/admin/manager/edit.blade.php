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
                <form action="{{ route('manager.update', $manager->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên nhân viên</label>
                        <input type="text" value="{{ $manager->name }}"
                            class="form-control @error('name') is-invalid @enderror" id="name"
                            aria-describedby="emailHelp" name="name">
                        @error('name')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" value="{{ $manager->email }}"
                            class="form-control @error('email') is-invalid @enderror" id="email"
                            aria-describedby="emailHelp" name="email">
                        @error('email')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Vai trò</label>
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
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $('.tag-select').select2({
                placeholder: "Chọn vai trò"
            })
        })
    </script>
@endsection
