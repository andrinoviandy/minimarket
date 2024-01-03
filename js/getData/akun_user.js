// console.log('Panggil DATA');
var search = document.getElementById("keyword")
var table = document.getElementById("table")
var paging2 = document.getElementById("paging-2")
var paging1 = document.getElementById("paging-1")
var dari = document.getElementById("dari")
var sampai = document.getElementById("sampai")
const jumlah_limit = parseInt(document.getElementById("jumlah_limit").value)
var tampil = parseInt(getVars("tampil"));
var tgl1 = getVars("tgl1");
var tgl2 = getVars("tgl2");
var jumlah_total = 0
var load_flag = 0
var key = '';

function cekPaging(flag) {
    if (jumlah_total <= jumlah_limit) {
        paging1.disabled = true;
        paging2.disabled = true;
    }
    else {
        if (flag < jumlah_limit) {
            paging1.disabled = true;
            paging2.disabled = false;
        }
        else if (flag >= jumlah_limit && flag < (jumlah_total - jumlah_limit)) {
            paging1.disabled = false;
            paging2.disabled = false;
        }
        else if (flag >= (jumlah_total - jumlah_limit)) {
            paging1.disabled = false;
            paging2.disabled = true;
        }
    }
}

function loading() {
    const xhr = new XMLHttpRequest()
    xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            table.innerHTML = xhr.responseText
        }
    }
    xhr.open('GET', "include/getLoading.php", true);
    xhr.send()
}

hitungBaris(key = '')
function hitungBaris(keyword) {
    const xhr = new XMLHttpRequest()
    xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = JSON.parse(xhr.responseText)
            jumlah_total = data.length
        }
    }
    const page = getVars("page").replace('#', '');

    if (keyword === '') {
        if (tgl1 === undefined && tgl2 === undefined) {
            xhr.open('GET', "json/" + page + ".php", true)
        } else {
            xhr.open('GET', "json/" + page + ".php?tgl1=" + tgl1 + "&tgl2=" + tgl2, true)
        }
    } else {
        if (tgl1 === undefined && tgl2 === undefined) {
            xhr.open('GET', "json/" + page + ".php?cari=" + keyword, true)
        } else {
            xhr.open('GET', "json/" + page + ".php?cari=" + keyword + "&tgl1=" + tgl1 + "&tgl2=" + tgl2, true)
        }
    }
    xhr.send()
}

function loadMore(start, keyword) {
    hitungBaris(keyword)
    const xhr = new XMLHttpRequest()
    xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
            table.innerHTML = xhr.responseText
        }
    }
    const page = getVars("page").replace('#', '');
    // console.log('tgl1', tgl1);
    // console.log('tgl2', tgl2);
    if (keyword === '') {
        if (tgl1 === undefined && tgl2 === undefined) {
            xhr.open('GET', "data/" + page + ".php?start=" + start + "&page=" + page + "&tampil=" + tampil, true)
        } else {
            xhr.open('GET', "data/" + page + ".php?start=" + start + "&page=" + page + "&tampil=" + tampil + "&tgl1=" + tgl1 + "&tgl2=" + tgl2, true)
        }
    } else {
        if (tgl1 === undefined && tgl2 === undefined) {
            xhr.open('GET', "data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&tampil=" + tampil, true)
        } else {
            xhr.open('GET', "data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&tampil=" + tampil + "&tgl1=" + tgl1 + "&tgl2=" + tgl2, true)
        }
    }
    xhr.send()
    // console.log('Loading...', start);
    // console.log('jumlah data', jumlah_total);
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

search.addEventListener('keyup', function () {
    loading()
    setTimeout(function () {
        loadMore(load_flag = 0, key = search.value)
        hitungBaris(key = search.value)
    }, 500);
})

paging2.addEventListener('click', function () {
    if (search.value == '') {
        loadMore(load_flag = load_flag + jumlah_limit, key);
    } else {
        loadMore(load_flag = load_flag + jumlah_limit, key = search.value);
    }
})

paging1.addEventListener('click', function () {
    if (search.value == '') {
        loadMore(load_flag = load_flag - jumlah_limit, key);
    } else {
        loadMore(load_flag = load_flag - jumlah_limit, key = search.value);
    }
})

jQuery(window).ready(function () {
    loading()
    setTimeout(function () {
        loadMore(load_flag, key)
    }, 500);
})