var search2 = document.getElementById("keyword2")
var table2 = document.getElementById("table2")
var paging2_2 = document.getElementById("paging-2_2")
var paging1_2 = document.getElementById("paging-1_2")
var dari2 = document.getElementById("dari2")
var sampai2 = document.getElementById("sampai2")
var id = parseInt(getVars("id"));
var jumlah_total2 = 0
var load_flag2 = 0
var key2 = '';

function cekPaging2(flag) {
    if (jumlah_total2 <= jumlah_limit) {
        paging1_2.disabled = true;
        paging2_2.disabled = true;
    }
    else {
        if (flag < jumlah_limit) {
            paging1_2.disabled = true;
            paging2_2.disabled = false;
        }
        else if (flag >= jumlah_limit && flag < (jumlah_total2 - jumlah_limit)) {
            paging1_2.disabled = false;
            paging2_2.disabled = false;
        }
        else if (flag >= (jumlah_total2 - jumlah_limit)) {
            paging1_2.disabled = false;
            paging2_2.disabled = true;
        }
    }
}

function loading2() {
    $.get("include/getLoading.php",
        function (data) {
            $('#table2').html(data);
        }
    );
}

async function hitungBaris(keyword) {
    const page = getVars("page").replace('#', '');
    let jmll = 0;
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

async function hitungBaris2(keyword) {
    const page = getVars("page").replace('#', '');
    let jmll = 0;
    if (keyword === '') {
        await $.get("json/" + page + "2.php?id=" + id,
            function (data) {
                jmll = data;
            }
        );
    } else {
        await $.get("json/" + page + "2.php?cari=" + keyword + "&id=" + id,
            function (data) {
                jmll = data;
            }
        );
    }
    jumlah_total2 = jmll;
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

async function loadMore2(start, keyword) {
    await hitungBaris2(keyword)

    const page = getVars("page").replace('#', '');
    // console.log('tgl1', tgl1);
    // console.log('tgl2', tgl2);
    if (keyword === '') {
        $.get("data/" + page + "2.php?start=" + start + "&page=" + page + "2&id=" + id,
            function (data) {
                $('#table2').html(data);
            }
        );
    } else {
        $.get("data/" + page + "2.php?start=" + start + "&page=" + page + "2&cari=" + keyword + "&id=" + id,
            function (data) {
                $('#table2').html(data);
            }
        );
    }

    cekPaging2(start)
    if (jumlah_total2 <= jumlah_limit) {
        dari2.innerText = 1
        sampai2.innerText = jumlah_total2
    } else {
        if (start == 0) {
            dari2.innerText = 1
            sampai2.innerText = jumlah_limit
        }
        else {
            if (jumlah_total2 - start < jumlah_limit) {
                dari2.innerText = start + 1
                sampai2.innerText = jumlah_total2
            } else {
                dari2.innerText = start + 1
                sampai2.innerText = start + jumlah_limit
            }
        }
    }
}

function form_cari2() {
    loading2()
    loadMore2(load_flag2 = 0, key2 = search2.value)
};

paging2_2.addEventListener('click', function () {
    if (search2.value == '') {
        loading2()
        loadMore2(load_flag2 = load_flag2 + jumlah_limit, key2);
    } else {
        loading2()
        loadMore2(load_flag2 = load_flag2 + jumlah_limit, key2 = search2.value);
    }
})

paging1_2.addEventListener('click', function () {
    if (search2.value == '') {
        loading2()
        loadMore2(load_flag2 = load_flag2 - jumlah_limit, key2);
    } else {
        loading2()
        loadMore2(load_flag2 = load_flag2 - jumlah_limit, key2 = search2.value);
    }
})

$(document).ready(function () {
    // hitungBaris(key)
    loading2()
    // setTimeout(function () {
    loadMore2(load_flag2, key2)
    // }, 500);
});