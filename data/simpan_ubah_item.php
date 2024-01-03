<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$cek = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail where no_seri_brg='" . $_POST['no_seri'] . "' and id !=" . $_POST['id_ubah'] . ""));
// echo $cek; die;
if ($cek > 0) {
    echo "SA";
} else {
    $u = mysqli_query($koneksi, "update barang_gudang_detail set no_bath='" . $_POST['no_bath'] . "', no_lot='" . $_POST['no_lot'] . "', no_seri_brg='" . $_POST['no_seri'] . "', tgl_expired='" . $_POST['expired'] . "' where id=" . $_POST['id_ubah'] . "");
    if ($u) {
        echo "S";
    } else {
        echo "F";
    }
}
