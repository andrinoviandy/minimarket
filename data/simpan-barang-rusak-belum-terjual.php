<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$simpan = mysqli_query($koneksi, "insert into barang_gudang_detail_rusak values('','" . $_POST['tgl_input'] . "','" . $_POST['no_seri'] . "','" . $_POST['kerusakan'] . "','','0')");
if ($simpan) {
    // if ($_POST['status'] == 2) {
    //     mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set barang_gudang_detail.status_kerusakan=2, barang_gudang.stok_total=barang_gudang.stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $_POST['no_seri'] . "");
    // } else {
        mysqli_query($koneksi, "update barang_gudang_detail,barang_gudang set barang_gudang_detail.status_kerusakan=1, barang_gudang.stok_total=barang_gudang.stok_total-1 where barang_gudang.id=barang_gudang_detail.barang_gudang_id and barang_gudang_detail.id=" . $_POST['no_seri'] . "");
    // }
    echo "S";
} else {
    echo "F";
}
