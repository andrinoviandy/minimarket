function loading() {
    $.get("include/getLoading.php", function (data) {
        $('#table').html(data);
    });
}