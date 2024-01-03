<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$del2 = mysqli_query($koneksi, "delete from barang_pesan_inventory_detail where barang_pesan_inventory_id=" . $_POST['id_hapus'] . "");
$del = mysqli_query($koneksi, "delete from barang_pesan_inventory where id=" . $_POST['id_hapus'] . "");
if ($del and $del2) {
    echo "S";
} else {
    echo "F";
}
