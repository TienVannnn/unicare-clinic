$(document).ready(function () {
    $("#checkall").change(function () {
        $(".checkbox-childrent").prop("checked", $(this).prop("checked"));
    });
    $(".checkbox-childrent").change(function () {
        if (
            $(".checkbox-childrent:checked").length ===
            $(".checkbox-childrent").length
        ) {
            $("#checkall").prop("checked", true);
        } else {
            $("#checkall").prop("checked", false);
        }
    });
});
