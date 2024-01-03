<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$hapus = mysqli_query($koneksi, "delete from aksesoris_alkes where barang_gudang_id=" . $_POST['id_hapus'] . "");
$del1 = mysqli_query($koneksi, "delete from barang_gudang_detail where barang_gudang_id=" . $_POST['id_hapus'] . "");
$del0 = mysqli_query($koneksi, "delete from barang_gudang_po where barang_gudang_id=" . $_POST['id_hapus'] . "");
$del2 = mysqli_query($koneksi, "delete from barang_gudang where id=" . $_POST['id_hapus'] . "");
if ($del2) {
    echo "S";
} else {
    echo "F";
}
