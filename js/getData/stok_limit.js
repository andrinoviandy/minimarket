async function hitungBaris(keyword) {
    let jmll = 0;
    const page = getVars("page").replace('#', '');
    if (keyword == '') {
        if (stok_limit === undefined) {
            await $.get("json/" + page + ".php",
                function (data) {
                    jmll = data;
                }
            );
        } else {
            await $.get("json/" + page + ".php?stok_limit=" + stok_limit,
                function (data) {
                    jmll = data;
                }
            );
        }
    } else {
        if (stok_limit === undefined) {
            await $.get("json/" + page + ".php?cari=" + keyword,
                function (data) {
                    jmll = data;
                }
            );
        } else {
            await $.get("json/" + page + ".php?cari=" + keyword + "&stok_limit=" + stok_limit,
                function (data) {
                    jmll = data;
                }
            );
        }
    }
    jumlah_total = jmll;
}

async function loadMore(start, keyword) {
    await hitungBaris(keyword)
    const page = getVars("page").replace('#', '');
    // console.log('tglPenjualan1', tglPenjualan1);
    // console.log('tglPenjualan2', tglPenjualan2);
    if (keyword == '') {
        if (stok_limit === undefined) {
            console.log('test1');
            $.get("data/" + page + ".php?start=" + start + "&page=" + page,
                function (data) {
                    $('#table').html(data);
                }
            );
        } else {
            console.log('test2');
            $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&stok_limit=" + stok_limit,
                function (data) {
                    $('#table').html(data);
                }
            );
        }
    } else {
        if (stok_limit === undefined) {
            console.log('test3');
            $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword,
                function (data) {
                    $('#table').html(data);
                }
            );
        } else {
            console.log('test4');
            $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&stok_limit=" + stok_limit,
                function (data) {
                    $('#table').html(data);
                }
            );
        }
    }
    cekPaging(start)
    if (jumlah_total <= jumlah_limit) {
        dari.innerText = 1
        sampai.innerText = jumlah_total
    } else {
        if (start == 0) {
            dari.innerText = 1
            sampai.innerText = jumlah_limit
        }
        else {
            if (jumlah_total - start < jumlah_limit) {
                dari.innerText = start + 1
                sampai.innerText = jumlah_total
            } else {
                dari.innerText = start + 1
                sampai.innerText = start + jumlah_limit
            }
        }
    }
}