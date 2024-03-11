<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from keuangan_detail where coa_sub_id = " . $_POST['hapus_aset'] . ""));
if ($cek['jml'] > 0) {
    echo "F";
} else {
    $q_sub = mysqli_query($koneksi, "delete from coa_sub_akun where coa_sub_id=" . $_POST['hapus_aset'] . "");
    $q = mysqli_query($koneksi, "delete from coa_sub where id=" . $_POST['hapus_aset'] . "");
    echo "S";
}
