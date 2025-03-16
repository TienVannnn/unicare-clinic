@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                Phản hồi tin nhắn
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('contact.index') }}">Quản lý liên hệ</a> / Trả lời tin nhắn
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <form action="{{ route('admin.handle-reply-contact') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $contact->id }}">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td style="width: 20%; white-space: nowrap;">Tiêu đề gửi</td>
                            <td><input type="text" name="title" value="Re:{{ $contact->title }}" readonly
                                    class="readonly form-control w-auto">
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 20%; white-space: nowrap;">Gửi tới email</td>
                            <td><input type="email" name="email" value="{{ $contact->email }} "
                                    class="readonly form-control w-auto" readonly></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea class="form-control" name="content" id="content">
                                <div class="email-content">
                                    <p>From: {{ $contact->email }}</p>
                                    <p>To: UNICARE</p>
                                    <p>Sent: {{ $contact->created_at->format('H:i d/m/Y') }}</p>
                                    <p>Message: {!! $contact->message !!}</p>
                                    <p>Subject: Re: {{ $contact->title }}</p> <br>

                                    Gửi {{ $contact->name }}, <br>

                                    Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi đánh giá cao sự kiên nhẫn của bạn. <br> <br>
                                    ------------------------------------ <br>
                                    Trân trọng, <br>
                                    {{ Auth()->guard('admin')->user()->name }} <br>
                                    {{ Auth()->guard('admin')->user()->email }}
                                </div>
                            </textarea>
                            </td>
                        </tr>
                    </table>
                </div>

                <table class="table table-striped table-bordered table-hover" style="margin-bottom: 100px">
                    <tr class="text-center">
                        <td>
                            <button type="submit" class="btn btn-success"><i class="far fa-paper-plane me-1"></i>Gửi
                                phản hồi</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' />
    <style>
        .email-content p {
            margin: 0;
            line-height: 1.5;
        }
    </style>
@endsection
@section('js')
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'>
    </script>
    <script>
        var editor = new FroalaEditor('#content', {
            height: 300,
            heightMax: 500
        });
    </script>
@endsection
