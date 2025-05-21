@extends('user.layout.main')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <div class="card shadow-sm mb-4">
                    <div class="card-header {{ request()->routeIs('user.faq') ? 'active' : '' }}">
                        <a href="{{ route('user.faq') }}"> <strong>CHUYÊN KHOA</strong></a>
                    </div>

                    <ul class="list-group list-group-flush">
                        @foreach ($departments as $department)
                            <li
                                class="list-group-item {{ request()->routeIs('user.faq-department') && request()->route('slug') == $department->slug ? 'active' : '' }}">
                                <a href="{{ route('user.faq-department', $department->slug) }}" class="text-decoration-none">
                                    {{ $department->name }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="text-orange">ĐẶT CÂU HỎI VỚI CÁC BÁC SĨ CỦA UNICARE</h5>
                    @if (isset($de))
                        <p class="text-orange" style="font-weight: 600">CHUYÊN KHOA: {{ $de->name }}</p>
                    @endif
                </div>

                <div class="accordion" id="faqAccordion">
                    @if ($faqs->count() > 0)
                        @foreach ($faqs as $faq)
                            <hr>
                            <div class="accordion-item pb-3 mb-3">
                                <div>
                                    <i class="fa fa-calendar mr-1"></i>Ngày đăng: {{ $faq->created_at->format('d/m/Y') }} |
                                    <i class="fa fa-edit mr-1"></i>{{ $faq->user->name }}
                                </div>
                                <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                    <button
                                        class="accordion-button collapsed text-orange text-start d-flex justify-content-between align-items-center w-100"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $faq->id }}" aria-expanded="false"
                                        aria-controls="#collapse{{ $faq->id }}"
                                        style="border: none; background: none; font-size: 17px; font-weight: 500; line-height: 26px;">
                                        <span class="me-2">{{ $faq->title }}</span>
                                        @if ($faq->answer)
                                            <svg style="width: 13px;" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 512 512">
                                                <path fill="#f05a28"
                                                    d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                            </svg>
                                        @endif
                                    </button>
                                    <div
                                        style="font-size: 14px;line-height: 20px;font-weight: 400; margin-top:7px; color: #212529">
                                        {!! $faq->question !!}</div>
                                </h2>
                                @if ($faq->answer)
                                    <div style="background-color: #f6f6f6; color: #212529" id="collapse{{ $faq->id }}"
                                        class="accordion-collapse collapse p-3"
                                        aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="font-weight-bold"><i class="fa fa-edit mr-1"></i>Bs
                                                    {{ $faq->doctor->name }}</div>
                                                <div><i class="fa fa-calendar mr-1"></i>Ngày trả lời:
                                                    {{ $faq->updated_at->format('d/m/Y') }}
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                {!! nl2br(e($faq->answer)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        @endforeach
                    @else
                        <h5 class="text-danger">Chưa có câu hỏi nào!</h5>
                    @endif
                </div>

                <div class="mt-3">
                    {{ $faqs->links() }}
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="text-orange mb-0"><i class="bi bi-plus-circle"></i> ĐẶT CÂU HỎI</h5>
                        <small class="text-muted">
                            @if (auth()->check())
                                Quý khách vui lòng điền đầy đủ
                                thông tin bên dưới
                            @else
                                Vui lòng <a href="{{ route('user.login') }}" class="text-danger">Đăng nhập</a> để đặt câu
                                hỏi
                            @endif
                        </small>
                    </div>
                    <div class="card-body">
                        @if (auth()->check())
                            <form method="POST" action="{{ route('user.ask-question') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Chuyên Khoa</label>
                                    <select style="font-size: 14px" class="form-control" name="department">
                                        <option value="">Chọn chuyên khoa</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                        <div class="message-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tiêu Đề</label>
                                    <input type="text" class="form-control" name="title" placeholder="Nhập tiêu đề">
                                    @error('title')
                                        <div class="message-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Câu Hỏi</label>
                                    <textarea style="font-size: 14px" class="form-control" name="question" placeholder="Nhập nội dung câu hỏi"
                                        rows="4"></textarea>
                                    @error('question')
                                        <div class="message-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-danger w-100">Gửi Câu Hỏi</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
