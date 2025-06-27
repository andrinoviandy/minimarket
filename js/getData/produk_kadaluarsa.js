async function hitungBaris(keyword) {
    let jmll = 0;
    const page = getVars("page").replace('#', '');
    if (keyword == '') {
        if (expired_to === undefined) {
            await $.get("json/" + page + ".php",
                function (data) {
                    jmll = data;
                }
            );
        } else {
            await $.get("json/" + page + ".php?expired_to=" + expired_to,
                function (data) {
                    jmll = data;
                }
            );
        }
    } else {
        if (expired_to === undefined) {
            await $.get("json/" + page + ".php?cari=" + keyword,
                function (data) {
                    jmll = data;
                }
            );
        } else {
            await $.get("json/" + page + ".php?cari=" + keyword + "&expired_to=" + expired_to,
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
        if (expired_to === undefined) {
            console.log('test1');
            $.get("data/" + page + ".php?start=" + start + "&page=" + page,
                function (data) {
                    $('#table').html(data);
                }
            );
        } else {
            console.log('test2');
            $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&expired_to=" + expired_to,
                function (data) {
                    $('#table').html(data);
                }
            );
        }
    } else {
        if (expired_to === undefined) {
            console.log('test3');
            $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword,
                function (data) {
                    $('#table').html(data);
                }
            );
        } else {
            console.log('test4');
            $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&expired_to=" + expired_to,
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