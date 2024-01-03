var id = parseInt(getVars("id"));

async function hitungBaris(keyword) {
    let jmll = 0;
    const page = getVars("page").replace('#', '');
    if (keyword === '') {
        await $.get("json/" + page + ".php?id=" + id,
            function (data) {
                jmll = data;
            }
        );
    } else {
        await $.get("json/" + page + ".php?cari=" + keyword + "&id=" + id,
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
    // console.log('tgl1', tgl1);
    // console.log('tgl2', tgl2);
    if (keyword === '') {
        $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&id=" + id,
            function (data) {
                $('#table').html(data);
            }
        );
    } else {
        $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&id=" + id,
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