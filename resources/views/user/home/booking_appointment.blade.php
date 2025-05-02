@extends('user.layout.main')

@section('content')
    <section class="appointment">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Đặt lịch hẹn khám</h2>
                        <img src="/user/assets/img/section-img.png" alt="#" />
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 col-md-12 col-12 mb-3" style="box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;">
                    <form class="form" id="book-appointment-form" action="{{ route('user.book-appointment') }}"
                        method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Họ tên</label>
                                    <input name="name" id="name" type="text" placeholder="Nhập tên" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input name="email" id="email" type="email" placeholder="Nhập email" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Điện thoại</label>
                                    <input name="phone" id="phone" type="text" placeholder="Nhập số điện thoại" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="dob" class="form-label">Ngày sinh</label>
                                    <input name="dob" id="dob" type="date" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="gender" class="form-label">Giới tính</label>
                                    <select name="gender" id="gender" class="form-custom">
                                        <option value="1">Nam</option>
                                        <option value="2">Nam</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <label for="department" class="form-label">Chuyên khoa</label>
                                <select name="department_id" class="form-custom">
                                    <option value="" selected>Chọn chuyên khoa</option>
                                    @if ($departments)
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="doctor" class="form-label">Bác sĩ</label>
                                    <select name="doctor_id" class="form-custom" id="doctor_id">
                                        <option value="" selected>Chọn bác sĩ</option>
                                        @if ($doctors)
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="appointment_date" class="form-label">Ngày khám</label>
                                    <input type="date" name="appointment_date" id="appointment_date">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="slot_list" class="form-label">Khung giờ khám</label>
                                    <select id="slot_select" name="start_time" class="form-custom">
                                        <option value="">-- Chọn giờ khám --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="form-group">
                                    <label for="note" class="form-label">Ghi chú</label>
                                    <textarea name="note" id="note" placeholder="Nhập ghi chú....."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-3 col-12">
                                <div class="form-group">
                                    <div class="button">
                                        <button type="submit" class="btn">
                                            Gửi yêu cầu
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-9 col-12">
                                <p>(Chúng tôi sẽ xác nhận bằng tin nhắn của bạn)</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('css')
    <style>
        .form-custom {
            display: block !important;
            width: 100%;
            height: 50px;
            border-radius: 5px;
        }
    </style>
@endsection
@section('js')
    <script src="{{ asset('user/assets/js/custom/book-appointment.js') }}"></script>
@endsection
