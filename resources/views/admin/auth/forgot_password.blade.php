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
                    <div class="col-md-6 col-lg-4 col-sm-6">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="/admin-assets/img/logouni2.png" alt="" style="width: 20%">
                                </a>
                                <p class="text-center text-small">Vui lòng nhập email đăng nhập của bạn,
                                    chúng tôi sẽ gửi mã xác
                                    nhận cho bạn qua email này.</p>
                                <form method="POST" action="{{ route('admin.handle_forgot_password') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror" id="email"
                                            aria-describedby="emailHelp" value="{{ old('email') }}"
                                            placeholder="Enter email">
                                        @error('email')
                                            <div class="message-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8  mb-4 rounded-2"><i
                                            class="fas fa-paper-plane me-2"></i>Gửi mã xác nhận</button>
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
