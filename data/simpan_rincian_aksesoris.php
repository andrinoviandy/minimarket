<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$cek = mysqli_num_rows(mysqli_query($koneksi, "select * from barang_gudang_detail_akse where barang_gudang_id = " . $_POST['id_akse'] . " and barang_gudang_akse_id = " . $_POST['id'] . ""));
if ($cek == 0) {
    $Result = mysqli_query($koneksi, "insert into barang_gudang_detail_akse values('','" . $_POST['id'] . "','" . $_POST['id_akse'] . "', '" . $_POST['qty'] . "')");
    if ($Result) {
        echo "S";
    } else {
        echo "F";
    }
} else {
    echo "SAMA";
}
