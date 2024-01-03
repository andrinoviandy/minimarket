<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "select * from barang_gudang JOIN barang_gudang_detail ON barang_gudang.id = barang_gudang_detail.barang_gudang_id where barang_gudang_detail.id = " . $_GET['id'] . ""));
echo (json_encode($data));
?>