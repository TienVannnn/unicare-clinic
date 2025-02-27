<script src="/user/assets/js/jquery.min.js"></script>
<script src="/user/assets/js/jquery-migrate-3.0.0.js"></script>
<script src="/user/assets/js/easing.js"></script>
<script src="/user/assets/js/popper.min.js"></script>
<script src="/user/assets/js/slicknav.min.js"></script>
<script src="/user/assets/js/jquery.scrollUp.min.js"></script>
<script src="/user/assets/js/niceselect.js"></script>
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
