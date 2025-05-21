@extends('user.auth.layout_profile')
@section('content_profile')
    <div class="row">
        <div class="col-12">
            Xin chào <span class="font-weight-bold">{{ Auth::user()->name }}</span>
            @if ($faqs->count() > 0)
                Dưới đây là các câu hỏi mà bạn đã hỏi bác sĩ
                @foreach ($faqs as $faq)
                    <hr>
                    <div class="accordion-item pb-3 mb-3">
                        <div>
                            <i class="fa fa-calendar mr-1"></i>Ngày đăng: {{ $faq->created_at->format('d/m/Y') }}
                        </div>
                        <h2 class="accordion-header" id="heading{{ $faq->id }}">
                            <button
                                class="accordion-button collapsed text-orange text-start d-flex justify-content-between align-items-center w-100"
                                type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                                aria-expanded="false" aria-controls="#collapse{{ $faq->id }}"
                                style="border: none; background: none; font-size: 17px; font-weight: 500; line-height: 26px;">
                                <span class="me-2">{{ $faq->title }}</span>
                                @if ($faq->answer)
                                    <svg style="width: 13px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="#f05a28"
                                            d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z" />
                                    </svg>
                                @endif
                            </button>
                            <div style="font-size: 14px;line-height: 20px;font-weight: 400; margin-top:7px; color: #212529">
                                {!! $faq->question !!}</div>
                        </h2>
                        @if ($faq->answer)
                            <div style="background-color: #f6f6f6; color: #212529" id="collapse{{ $faq->id }}"
                                class="accordion-collapse collapse p-3" aria-labelledby="heading{{ $faq->id }}"
                                data-bs-parent="#faqAccordion">
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
                <p>Bạn chưa đặt câu hỏi nào!</p>
            @endif
            <div class="mt-3">
                {{ $faqs->links() }}
            </div>
            <a href="{{ route('user.faq') }}" style="font-weight: bold; color: #f05a28">Đặt câu hỏi</a>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
