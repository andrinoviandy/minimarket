<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$cek = mysqli_fetch_array(mysqli_query($koneksi, "select ((select count(*) from barang_dijual_qty where barang_gudang_id = ".$_POST['id_hapus'].") + (select count(*) from barang_dijual_qty_detail where barang_gudang_id = ".$_POST['id_hapus'].")) as jml from dual"));
if ($cek['jml'] > 0) {
    die('T');
} else {
    $hapus = mysqli_query($koneksi, "delete from aksesoris_alkes where barang_gudang_id=" . $_POST['id_hapus'] . "");
    $del1 = mysqli_query($koneksi, "delete from barang_gudang_detail where barang_gudang_id=" . $_POST['id_hapus'] . "");
    $del0 = mysqli_query($koneksi, "delete from barang_gudang_po where barang_gudang_id=" . $_POST['id_hapus'] . "");
    $del2 = mysqli_query($koneksi, "delete from barang_gudang where id=" . $_POST['id_hapus'] . "");
    if ($del2) {
        echo "S";
    } else {
        echo "F";
    }
}
