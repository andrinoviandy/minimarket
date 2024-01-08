<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$d1 = mysqli_query($koneksi, "delete from barang_demo_qty where barang_demo_id=" . $_POST['id'] . "");
$d2 = mysqli_query($koneksi, "delete from barang_demo where id=" . $_POST['id'] . "");
if ($d1 and $d2) {
    echo "S";
} else {
    echo "F";
}
