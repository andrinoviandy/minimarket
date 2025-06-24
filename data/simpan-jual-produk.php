<?php
include("../config/koneksi.php");
include("../include/helper.php");
session_start();
// error_reporting(0);
$stmt = $koneksi->prepare("select count(*) as jml from penjualan_qty_temp where produk_id = ? and akun_id = ? and status = 0");
$params = [$_POST['produk_id'], $_SESSION['id']];
$types = getBindTypes($params);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$cek = $result->fetch_assoc();
if ($cek['jml'] > 0) {
    $update1 = $koneksi->prepare("update penjualan_qty_temp set qty_jual = qty_jual + ? where akun_id = ? and produk_id = ?");
    $params1 = [$_POST['jumlah_order'], $_SESSION['id'], $_POST['produk_id']];
    $types1 = getBindTypes($params1);
    $update1->bind_param($types1, ...$params1);
    $simpan0 = $update1->execute();
    if ($simpan0) {
        die("S");
    } else {
        die('F');
    }
} else {
    mysqli_begin_transaction($koneksi);
    $update2 = $koneksi->prepare("insert into penjualan_qty_temp(akun_id, produk_id, harga_jual_saat_itu, qty_jual) values(?, ?, ?, ?)");
    $params2 = [$_SESSION['id'], $_POST['produk_id'], $_POST['harga_beli'], $_POST['jumlah_order']];
    $types2 = getBindTypes($params2);
    $update2->bind_param($types2, ...$params2);
    $simpan1 = $update2->execute();
    if ($simpan1) {
        mysqli_commit($koneksi);
        die("S");
    } else {
        mysqli_rollback($koneksi);
        die('F');
    }
}
