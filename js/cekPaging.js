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