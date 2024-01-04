var id = parseInt(getVars("id"));
// status_b = 'Tersedia';

async function hitungBaris(keyword, status_brg) {
    let jmll = 0;
    const page = getVars("page").replace('#', '');
    if (keyword === '') {
        await $.get("json/" + page + ".php?id=" + id + "&status=" + status_brg,
                function (data) {
                    jmll = data;
                }
            );
    } else {
        await $.get("json/" + page + ".php?cari=" + keyword + "&id=" + id + "&status=" + status_brg,
                function (data) {
                    jmll = data;
                }
            );
    }
    jumlah_total = jmll;
}

async function loadMore(start, keyword, status_brg) {
    await hitungBaris(keyword, status_brg)
    const page = getVars("page").replace('#', '');
    // console.log('tgl1', tgl1);
    // console.log('tgl2', tgl2);
    if (keyword === '') {
        $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&id=" + id + "&status=" + status_brg,
            function (data) {
                $('#table').html(data);
            }
        );
    } else {
        $.get("data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&id=" + id + "&status=" + status_brg,
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