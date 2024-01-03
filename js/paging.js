$('#paging-1').click(function (e) {
    // e.preventDefault();
    loading()
    if (search.value == '') {
        loadMore(load_flag = load_flag - jumlah_limit, key, status_b);
    } else {
        loadMore(load_flag = load_flag - jumlah_limit, key = search.value, status_b);
    }
});
$('#paging-2').click(function (e) {
    // e.preventDefault();
    loading()
    if (search.value == '') {
        loadMore(load_flag = load_flag + jumlah_limit, key, status_b);
    } else {
        loadMore(load_flag = load_flag + jumlah_limit, key = search.value, status_b);
    }
});