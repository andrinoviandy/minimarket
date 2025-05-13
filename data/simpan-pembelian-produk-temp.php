<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$total = intval(str_replace(".","",$_POST['qty'])) * intval(str_replace(".","",$_POST['harga_beli']));
$nilai_diskon = floatval($_POST['diskon']) * $total;
$total_harga = $total - $nilai_diskon;
$simpan = mysqli_query($koneksi, "insert into pembelian_detail_temp values('','" . $_SESSION['id'] . "','" . $_POST['id_akse'] . "','" . $_POST['qty'] . "','" . $_POST['harga_beli'] . "','" . $_POST['diskon'] . "','" . ($total_harga) . "')");
if ($simpan) {
    echo "S";
} else {
    echo "F";
}
