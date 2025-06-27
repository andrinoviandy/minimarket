async function hitungBaris(keyword) {
    let jmll = 0;
    const page = getVars("page").replace('#', '');
    if (keyword == '') {
        await $.get("json/" + page + ".php",
            function (data) {
                jmll = data;
            }
        );
    } else {
        await $.get("json/" + page + ".php?cari=" + keyword,
            function (data) {
                jmll = data;
            }
        );
    }
    jumlah_total = jmll;
}

async function loadMore(start, keyword) {
    await hitungBaris(keyword)
    const page = getVars("page").replace('#', '');
    // console.log('tglLaris1', tglLaris1);
    // console.log('tglLaris2', tglLaris2);
    if (keyword == '') {
        $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&tampil=" + tampil,
            function (data) {
                $('#table').html(data);
            }
        );
    } else {
        $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&tampil=" + tampil,
            function (data) {
                $('#table').html(data);
            }
        );
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