<li class="nav-item topbar-icon dropdown hidden-caret">
    <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-envelope" title="Xem tin nhắn liên hệ" data-bs-toggle="tooltip"></i>
        @if ($count > 0)
            <span class="notification noti-contact-count">{{ $count }}</span>
        @else
            <span class="noti-contact-count"></span>
        @endif
    </a>
    <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
        <li>
            <div class="dropdown-title d-flex justify-content-between align-items-center">
                Liên hệ
                <a href="#" class="small">Đánh dấu tất cả đã đọc</a>
            </div>
        </li>
        <li>
            <div class="message-notif-scroll scrollbar-outer">
                <div class="notif-center noti-contact">
                    @if ($contacts->isNotEmpty())
                        @foreach ($contacts as $contact)
                            <a href="{{ route('contact.show', $contact->id) }}"
                                class="{{ $contact->status == 0 ? 'fw-bold text-black' : '' }}"
                                title="@if ($contact->status == 0) Chưa đọc
                                @elseif($contact->status == 1)
                                Đã đọc
                                @else
                                Đã phản hồi @endif">
                                <div class="notif-icon {{ $contact->status == 0 ? 'notif-danger' : 'notif-success' }}">
                                    <i class="fa fa-comment"></i>
                                </div>
                                <div class="notif-content">
                                    <span class="subject">{{ $contact->name }}</span>
                                    <span class="block"> {{ $contact->title }}</span>
                                    <span class="time">{{ $contact->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="p-3">
                            <small class="text-danger">Chưa có tin nhắn liên hệ nào!</small>
                        </div>
                    @endif
                </div>
            </div>
        </li>
        <li>
            <a class="see-all" href="{{ route('contact.index') }}">Xem tất cả thư<i class="fa fa-angle-right"></i>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item topbar-icon dropdown hidden-caret">
    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bell" title="Xem lịch hẹn khám" data-bs-toggle="tooltip"></i>
        @if ($countAppointment > 0)
            <span class="notification noti-appointment-count">{{ $countAppointment }}</span>
        @else
            <span class="noti-appointment-count"></span>
        @endif
    </a>
    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
        @if ($countAppointment > 0)
            <li>
                <div class="dropdown-title">
                    Bạn có {{ $countAppointment }} chưa đọc
                </div>
            </li>
        @endif
        <li>
            <div class="notif-scroll scrollbar-outer">
                <div class="notif-center noti-appointment">
                    @if ($appointments->isNotEmpty())
                        @foreach ($appointments as $appointment)
                            <a href="{{ route('appointment.show', $appointment->id) }}"
                                class="{{ $appointment->status == 0 ? 'fw-bold text-black' : '' }}"
                                title="@if ($appointment->isviewed) Đã đọc
                            @else
                            Chưa đọc @endif">
                                <div class="notif-icon notif-primary">
                                    <i class="fa fa-user-plus"></i>
                                </div>
                                <div class="notif-content">
                                    <span class="block"> {{ $appointment->name }} đã đặt lịch hẹn khám</span>
                                    <span class="time">{{ $appointment->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="p-3">
                            <small class="text-danger">Chưa có lịch hẹn khám nào!</small>
                        </div>
                    @endif
                </div>
            </div>
        </li>
        <li>
            <a class="see-all" href="{{ route('appointment.index') }}">Xem tất cả lịch hẹn khám<i
                    class="fa fa-angle-right"></i>
            </a>
        </li>
    </ul>
</li>
