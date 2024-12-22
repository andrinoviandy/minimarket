<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from barang_dijual where id=" . $_POST['id_batal'] . ""));
$cek_kirim = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_dikirim where no_po_jual='" . $sel['no_po_jual'] . "'"));
$cek = mysqli_num_rows(mysqli_query($koneksi, "select * from utang_piutang,utang_piutang_bayar where utang_piutang.id=utang_piutang_bayar.utang_piutang_id and no_faktur_no_po='" . $sel['no_po_jual'] . "'"));
if ($cek == 0 && $cek_kirim == 0) {
    $q = mysqli_query($koneksi, "select * from barang_dijual where no_po_jual='" . $sel['no_po_jual'] . "'");
    while ($d = mysqli_fetch_array($q)) {
        $qq = mysqli_query($koneksi, "select id from barang_dijual_qty where barang_dijual_id='" . $d['id'] . "'");
        while ($dd = mysqli_fetch_array($qq)) {
            mysqli_query($koneksi, "delete from barang_dijual_qty_detail where barang_dijual_qty_id = $dd[id]");
        }
        $del1 = mysqli_query($koneksi, "delete from barang_dijual_qty where barang_dijual_id='" . $d['id'] . "'");
    }
    $del2 = mysqli_query($koneksi, "delete from barang_dijual where no_po_jual='" . $sel['no_po_jual'] . "'");
    if ($del2 & $del1) {
        echo "S";
    } else {
        echo "F";
    }
} else {
    echo "TB";
}
