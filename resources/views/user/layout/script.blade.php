<script src="/user/assets/js/jquery.min.js"></script>
<script src="/user/assets/js/jquery-migrate-3.0.0.js"></script>
<script src="/user/assets/js/easing.js"></script>
<script src="/user/assets/js/popper.min.js"></script>
<script src="/user/assets/js/slicknav.min.js"></script>

<script src="/user/assets/js/owl-carousel.js"></script>
<script src="/user/assets/js/jquery.counterup.min.js"></script>
<script src="/user/assets/js/wow.min.js"></script>
<script src="/user/assets/js/jquery.magnific-popup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
<script src="/user/assets/js/bootstrap.min.js"></script>
<script src="/user/assets/js/main.js"></script>
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
<script type="text/javascript">
    var Tawk_API = Tawk_API || {},
        Tawk_LoadStart = new Date();
    (function() {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/67ea7495742217190dc04290/1inlteqn3';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();
</script>
<script src="/user/assets/js/jquery.scrollUp.min.js"></script>
<script>
    const observer = new MutationObserver(() => {
        let iframe = document.querySelector("iframe[title='chat widget']");
        if (iframe) {
            iframe.style.bottom = "10px";
            iframe.style.right = "10px";
            window.addEventListener("scroll", function() {
                if (window.scrollY > 290) {
                    iframe.classList.add("shift-up");
                } else {
                    iframe.classList.remove("shift-up");
                }
            });
            observer.disconnect();
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
</script>
