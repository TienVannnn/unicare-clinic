@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                Chi tiết câu hỏi
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('faq.index') }}">Quản lý câu hỏi</a> / Chi tiết
                câu hỏi
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="d-flex align-items-center p-3">
                <i class="fas fa-question-circle me-2 fs-3" style="color: #f05a28"></i> {{ $faq->title }}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered ">
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 700;text-transform: capitalize;">Thông
                            tin người dùng</td>
                        <td>{{ $faq->user->name }} <i class="fas fa-angle-left"></i> {{ $faq->user->email }}
                            <i class="fas fa-angle-right"></i><br>
                            @if ($faq->user->phone)
                                Điện thoại:
                                {{ $faq->user->phone }} <br>
                            @endif
                            Thời gian: {{ $faq->created_at->format('H:i d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 700;text-transform: capitalize;">Tình
                            trạng</td>
                        <td class="status-element" data-id="{{ $faq->id }}">
                            @if (!$faq->answer)
                                <span class="badge badge-danger">Chưa trả lời</span>
                            @else
                                <span class="badge badge-success"> Đã trả lời</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 700;text-transform: capitalize;">Chuyên
                            khoa
                        </td>
                        <td> {{ $faq->department->name }} </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 700;text-transform: capitalize;">Chủ đề
                        </td>
                        <td> {{ $faq->title }} </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 700;text-transform: capitalize;">Câu hỏi
                        </td>
                        <td> {{ $faq->question }} </td>
                    </tr>
                    @if ($faq->answer)
                        <tr>
                            <td style="width: 20%; white-space: nowrap; font-weight: 700;text-transform: capitalize;">Bác sĩ
                                trả lời
                            </td>
                            <td> {{ $faq->doctor->name }} </td>
                        </tr>
                    @endif
                </table>
            </div>
            <form action="{{ route('faq.update', $faq->id) }}" class="m-4" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="answer" class="form-label text-uppercase" style="color: #f05a28!important">Câu trả lời của
                        bác
                        sĩ</label>
                    <textarea name="answer" id="answer" class="form-control" rows="6" placeholder="Nhập câu trả lời">{{ $faq->answer }}</textarea>
                    @error('answer')
                        <div class="message-error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label for="status">Trạng thái</label>
                    <select name="status" id="status" class="form-select">
                        <option value="1">Công khai</option>
                        <option value="0">Riêng tư</option>
                    </select>
                    @error('status')
                        <div class="message-error">{{ $message }}</div>
                    @enderror
                </div>
                <a href="{{ route('faq.index') }}" class="btn btn-primary">Quay lại</a>
                @if ($doctor->department->id == $faq->department->id)
                    <button type="submit" class="btn btn-success">Trả lời</button>
                @endif
            </form>
        </div>
    </div>
@endsection
