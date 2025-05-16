var pusher = new Pusher("249a81d47a6525f25f67", {
    cluster: "ap1",
    encrypted: true,
});
var channel = pusher.subscribe("contact-channel");
channel.bind("contact-created", function (data) {
    if (!$(".noti-contact-count").hasClass("notification")) {
        $(".noti-contact-count").addClass("notification");
    }
    $(".noti-contact-count").text(data.count);
    let url = route("contact.show", data.id);
    var newNotification = `
    <a href="${url}" class="fw-bold text-black" title="Chưa đọc">
        <div class="notif-icon notif-danger">
            <i class="fa fa-comment"></i>
        </div>
        <div class="notif-content">
             <span class="subject">${data.name}</span>
            <span class="block">${data.title}</span>
            <span class="time">Vừa xong</span>
        </div>
    </a>
`;
    $(".noti-contact").prepend(newNotification);
});

var channel_appointment = pusher.subscribe("appointment-channel");
channel_appointment.bind("appointment-created", function (data) {
    if (!$(".noti-appointment-count").hasClass("notification")) {
        $(".noti-appointment-count").addClass("notification");
    }
    $(".noti-appointment-count").text(data.count);
    let url = route("appointment.show", data.id);
    var newNotificationAppointment = `
    <a href="${url}" class="fw-bold text-black" title="Chưa đọc">
        <div class="notif-icon notif-primary">
            <i class="fa fa-user-plus"></i>
        </div>
        <div class="notif-content">
            <span class="block">${data.name} đã đặt lịch hẹn khám</span>
            <div class="d-flex justify-content-between align-items-center">
                <span class="time">Vừa xong</span>
                <span style="color: #ff9523; font-size: 11px;">Bs
                    ${data.doctor}</span>
            </div>
        </div>
    </a>
`;
    $(".noti-appointment").prepend(newNotificationAppointment);
});
