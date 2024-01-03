export function loadMore(start, keyword) {
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
        xhr.open('GET', "data/" + page + ".php?start=" + start + "&page=" + page + "&tampil=" + tampil, true)
    } else {
        xhr.open('GET', "data/" + page + ".php?start=" + start + "&page=" + page + "&cari=" + keyword + "&tampil=" + tampil, true)
    }
    xhr.send()
    console.log('Loading...', start);
    console.log('jumlah data', jumlah_total);
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