<li class="nav-item topbar-icon dropdown hidden-caret">
    <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-envelope" title="Xem tin nhắn liên hệ" data-bs-toggle="tooltip"></i>
        @if ($count > 0)
            <span class="notification noti-contact-count">{{ $count }}</span>
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
                    @if ($contacts)
                        @foreach ($contacts as $contact)
                            <a href="#">
                                <div class="notif-img">
                                    <img src="/admin-assets/img/jm_denis.jpg" alt="Img Profile" />
                                </div>
                                <div class="notif-content">
                                    <span class="subject">{{ $contact->name }}</span>
                                    <span class="block"> {{ $contact->title }}</span>
                                    <span class="time">{{ $contact->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <p>Chưa có liên hệ nào!</p>
                    @endif
                </div>
            </div>
        </li>
        <li>
            <a class="see-all" href="javascript:void(0);">Xem tất cả thư<i class="fa fa-angle-right"></i>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item topbar-icon dropdown hidden-caret">
    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-bell" title="Xem lịch hẹn" data-bs-toggle="tooltip"></i>
        <span class="notification">4</span>
    </a>
    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
        <li>
            <div class="dropdown-title">
                Bạn có 4 lịch hẹn mới
            </div>
        </li>
        <li>
            <div class="notif-scroll scrollbar-outer">
                <div class="notif-center">
                    <a href="#">
                        <div class="notif-icon notif-primary">
                            <i class="fa fa-user-plus"></i>
                        </div>
                        <div class="notif-content">
                            <span class="block"> New user registered </span>
                            <span class="time">5 minutes ago</span>
                        </div>
                    </a>
                </div>
            </div>
        </li>
        <li>
            <a class="see-all" href="javascript:void(0);">Xem tất cả lịch hẹn<i class="fa fa-angle-right"></i>
            </a>
        </li>
    </ul>
</li>
