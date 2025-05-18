<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from penjualan_qty_temp where produk_id = ".$_POST['produk_id']." and akun_id = " . $_SESSION['id'] . " and status = 0"));
if ($cek['jml'] > 0) {
    $simpan0 = mysqli_query($koneksi, "update penjualan_qty_temp set qty_jual = qty_jual+'" . $_POST['jumlah_order'] . "' where akun_id = $_SESSION[id] and produk_id = ".$_POST['produk_id']."");
    if ($simpan0) {
        die("S");
    } else {
        die('F');
    }
} else {
    $simpan1 = mysqli_query($koneksi, "insert into penjualan_qty_temp(akun_id, produk_id, harga_jual_saat_itu, qty_jual) values('" . $_SESSION['id'] . "','" . $_POST['produk_id'] . "','" . $_POST['harga_beli'] . "', '" . $_POST['jumlah_order'] . "')");
    if ($simpan1) {
        die("S");
    } else {
        die('F');
    }
}
