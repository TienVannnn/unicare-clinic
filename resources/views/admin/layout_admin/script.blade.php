<!--   Core JS Files   -->
<script src="/admin-assets/js/core/jquery-3.7.1.min.js"></script>
<script src="/admin-assets/js/core/popper.min.js"></script>
<script src="/admin-assets/js/core/bootstrap.min.js"></script>
<script src="/admin-assets/js/plugin/chart.js/chart.min.js"></script>
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
<script src="{{ asset('user/assets/js/custom/pusher.js') }}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
