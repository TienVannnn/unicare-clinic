@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                Chi tiết liên hệ
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('contact.index') }}">Quản lý liên hệ</a> / Chi tiết
                liên hệ
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="d-flex align-items-center p-3">
                <i class="fas fa-question-circle me-2 fs-3" style="color: #f05a28"></i> {{ $contact->title }}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered ">
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 700;text-transform: capitalize;">Thông
                            tin người dùng</td>
                        <td>{{ $contact->name }} <i class="fas fa-angle-left"></i> {{ $contact->email }} <i
                                class="fas fa-angle-right"></i> <br> Điện thoại:
                            {{ $contact->phone }} <br>
                            Thời gian: {{ $contact->created_at->format('H:i d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 700;text-transform: capitalize;">Tình
                            trạng</td>
                        <td class="status-element" data-id="{{ $contact->id }}">
                            @if ($contact->status == 0)
                                Chưa đọc
                            @elseif ($contact->status == 1)
                                Đã đọc
                            @else
                                Đã phản hồi
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 700;text-transform: capitalize;">Chủ đề
                        </td>
                        <td> {{ $contact->title }} </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 700;text-transform: capitalize;">Nội dung
                        </td>
                        <td> {{ $contact->message }} </td>
                    </tr>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <tr class="text-center">
                        <td>
                            <a href="javascript:void(0);" class="btn btn-info" title="Quay lại"
                                onclick="window.history.back()"><i class="fas fa-arrow-left me-2"></i>Quay
                                lại</a>&nbsp;
                            @can('tra-loi-lien-he')
                                <a href="{{ route('admin.reply-contact', $contact->id) }}" title="Gửi phản hồi"
                                    class="btn btn-success"><i class="far fa-paper-plane me-1 data-bs-toggle="tooltip"
                                        title="Gửi phản hồi"></i>Gửi
                                    phản hồi</a>
                                &nbsp;
                            @endcan
                            @can('xoa-lien-he')
                                <form action="{{ route('admin.contact-delete', $contact->id) }}" method="POST"
                                    class="delete-form" style="display: inline-block">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" title="Xóa tin nhắn" class="btn btn-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa tin nhắn này')">
                                        <i class="fas fa-trash me-2" data-bs-toggle="tooltip" title="Xóa tin nhắn"></i> Xóa
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                </table>
            </div>

            @if ($replies->count() > 0)
                <div class="d-flex align-items-center p-3">
                    <i class="fas fa-reply me-2 fs-3 text-success"></i> Phản hồi
                </div>
                @foreach ($replies as $reply)
                    <div class="table-responsive" style="margin-bottom: 100px">
                        <table class="table table-bordered ">
                            <tr>
                                <td style="width: 20%; white-space: nowrap;">Thông tin người gửi</td>
                                <td>{{ $reply->admin->name }} < {{ $reply->admin->email }}>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%; white-space: nowrap;">Thời gian</td>
                                <td colspan="3"> {{ $reply->created_at->format('H:i d/m/Y') }} </td>
                            </tr>
                            <tr>
                                <td colspan="2">{!! $reply->content !!} </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            @else
                <div style="margin-left: 10px">
                    <p class="text-danger">Chưa có phản hồi nào.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
