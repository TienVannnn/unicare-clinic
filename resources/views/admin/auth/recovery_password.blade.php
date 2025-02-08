<!doctype html>
<html lang="en">

<head>
    @include('admin.layout_admin.headonly')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-6 col-lg-4 col-sm-8">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="/admin-assets/img/logouni2.png" alt="" style="width: 20%">
                                </a>
                                <form method="POST" action="{{ route('admin.handle_recovery') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" name="email"
                                            class="form-control  @error('email') is-invalid @enderror" id="email"
                                            {{ $email ? 'disabled' : null }} value="{{ $email ?? old('email') }}"
                                            placeholder="Enter email" />
                                        @error('email')
                                            <div class="message-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="code" class="form-label">Code</label>
                                        <input type="text" name="token_reset_password"
                                            class="form-control @error('token_reset_password') is-invalid @enderror"
                                            id="code" aria-describedby="code"
                                            value="{{ old('token_reset_password') }}" placeholder="Enter code">
                                        @error('token_reset_password')
                                            <div class="message-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">New password</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            aria-describedby="passwordHelp" value="{{ old('password') }}"
                                            placeholder="Enter password">
                                        @error('password')
                                            <div class="message-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm" class="form-label">Confirm password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            aria-describedby="codeHelp" value="{{ old('password_confirmation') }}"
                                            placeholder="Confirm password">
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2"><i
                                            class="fas fa-window-restore me-2"></i>Khôi phục mật khẩu</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layout_admin.script')
</body>

</html>
