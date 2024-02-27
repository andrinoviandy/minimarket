<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$cek_no_seri = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_pinjam_detail_hash where barang_gudang_detail_id=" . $_POST['no_seri'] . ""));
if ($cek_no_seri == 0) {
    $simpan = mysqli_query($koneksi, "insert into barang_pinjam_detail_hash values('','" . $_SESSION['id'] . "','" . $_POST['no_seri'] . "')");
    if ($simpan) {
        echo "S";
    } else {
        echo "F";
    }
} else {
    echo "SA";
}
