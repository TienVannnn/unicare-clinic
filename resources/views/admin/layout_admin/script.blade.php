<!--   Core JS Files   -->
<script src="/admin-assets/js/core/jquery-3.7.1.min.js"></script>
<script src="/admin-assets/js/core/popper.min.js"></script>
<script src="/admin-assets/js/core/bootstrap.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="/admin-assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Datatables -->
<script src="/admin-assets/js/plugin/datatables/datatables.min.js"></script>

<script src="/admin-assets/js/kaiadmin.min.js"></script>
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

{!! Toastr::message() !!}
<script>
    @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}", "Thành công");
    @endif
    @if (Session::has('error'))
        toastr.error("{{ Session::get('error') }}", "Thất bại");
    @endif
</script>
