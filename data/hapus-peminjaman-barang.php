<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$d1 = mysqli_query($koneksi, "delete from barang_pinjam_detail where barang_pinjam_id=" . $_POST['id_hapus'] . "");
$d2 = mysqli_query($koneksi, "delete from barang_pinjam where id=" . $_POST['id_hapus'] . "");
if ($d1 && $d2) {
    echo "S";
} else {
    echo "F";
}
