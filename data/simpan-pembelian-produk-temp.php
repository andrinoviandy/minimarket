<?php
include("../config/koneksi.php");
include("../include/helper.php");
session_start();
error_reporting(0);
$total = intval(str_replace(".", "", $_POST['qty'])) * intval(str_replace(".", "", $_POST['harga_beli']));
$nilai_diskon = floatval($_POST['diskon']) * $total;
$total_harga = $total - $nilai_diskon;
mysqli_begin_transaction($koneksi);
$stmt = $koneksi->prepare("insert into pembelian_detail_temp(akun_id, produk_id, qty, harga_beli, diskon, total_harga) values(? ,? ,? ,? , ?, ?)");
$params = [$_SESSION['id'], $_POST['id_akse'], $_POST['qty'], str_replace(".", "", $_POST['harga_beli']), $_POST['diskon'], $total_harga];
$types = getBindTypes($params);
$stmt->bind_param($types, ...$params);
$simpan = $stmt->execute();
if ($simpan) {
    mysqli_commit($koneksi);
    echo "S";
} else {
    mysqli_rollback($koneksi);
    echo "F";
}
