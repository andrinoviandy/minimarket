<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$simpan = mysqli_query($koneksi, "insert into barang_demo_qty_hash values('','" . $_SESSION['id'] . "','" . $_POST['id_akse'] . "','" . $_POST['qty'] . "')");
if ($simpan) {
    echo "S";
} else {
    echo "F";
}
