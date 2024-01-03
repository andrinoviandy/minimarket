var stok_tersedia = document.getElementById("stok_tersedia")
var stok_terjual = document.getElementById("stok_terjual")
var stok_rusak = document.getElementById("stok_rusak")
var stok_tidak_layak = document.getElementById("stok_tidak_layak")
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

stok_tersedia.addEventListener('click', function () {
    // hitungBaris(key = '', status_b = 'Tersedia')
    search.value = '';
    stok_tersedia.className = 'btn btn-primary';
    stok_terjual.className = 'btn btn-default';
    stok_rusak.className = 'btn btn-default';
    stok_tidak_layak.className = 'btn btn-default';
    loading()
    // setTimeout(function () {
        loadMore(load_flag = 0, key = search.value, status_b = 'Tersedia')
        
    // }, 500);
})

stok_terjual.addEventListener('click', function () {
    // hitungBaris(key = '', status_b = 'Terjual')
    search.value = '';
    stok_tersedia.className = 'btn btn-default';
    stok_terjual.className = 'btn btn-primary';
    stok_rusak.className = 'btn btn-default';
    stok_tidak_layak.className = 'btn btn-default';
    loading()
    // setTimeout(function () {
        loadMore(load_flag = 0, key = search.value, status_b = 'Terjual')
        
    // }, 500);
})

stok_rusak.addEventListener('click', function () {
    // hitungBaris(key = '', status_b = 'Rusak')
    search.value = '';
    stok_tersedia.className = 'btn btn-default';
    stok_terjual.className = 'btn btn-default';
    stok_rusak.className = 'btn btn-primary';
    stok_tidak_layak.className = 'btn btn-default';
    loading()
    // setTimeout(function () {
        loadMore(load_flag = 0, key = search.value, status_b = 'Rusak')
    // }, 500);
})

stok_tidak_layak.addEventListener('click', function () {
    // hitungBaris(key = '', status_b = 'Tidak_Layak')
    search.value = '';
    stok_tersedia.className = 'btn btn-default';
    stok_terjual.className = 'btn btn-default';
    stok_rusak.className = 'btn btn-default';
    stok_tidak_layak.className = 'btn btn-primary';
    loading()
    // setTimeout(function () {
        loadMore(load_flag = 0, key = search.value, status_b = 'Tidak_Layak')
    // }, 500);
})