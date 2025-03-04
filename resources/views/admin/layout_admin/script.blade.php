<!--   Core JS Files   -->
<script src="/admin-assets/js/core/jquery-3.7.1.min.js"></script>
<script src="/admin-assets/js/core/popper.min.js"></script>
<script src="/admin-assets/js/core/bootstrap.min.js"></script>
<script src="/admin-assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
<script src="/admin-assets/js/plugin/datatables/datatables.min.js"></script>

<script src="/admin-assets/js/kaiadmin.min.js"></script>
<script src="/admin-assets/js/toastr.min.js"></script>

{!! Toastr::message() !!}
<script>
    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}", "Thành công");
    @endif
    @if (Session::has('error'))
        toastr.error("{{ Session::get('error') }}", "Thất bại");
    @endif
</script>


<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script>
    Pusher.logToConsole = true;
    var pusher = new Pusher("249a81d47a6525f25f67", {
        cluster: "ap1",
        encrypted: true
    });
    var channel = pusher.subscribe("contact-channel");
    channel.bind("contact-created", function(data) {
        $(".noti-contact-count").text(data.count);
        var newNotification = `
        <a href="#">
             <div class="notif-img">
                <img src="/admin-assets/img/jm_denis.jpg" alt="Img Profile" />
            </div>
            <div class="notif-content">
                 <span class="subject">${data.name}</span>
                <span class="block">${data.title}</span>
                <span class="time">Just now</span>
            </div>
        </a>
    `;
        $(".noti-contact").prepend(newNotification);
    });
</script>
