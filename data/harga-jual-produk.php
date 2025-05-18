<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$sql = "select sum(harga_jual_saat_itu*qty_jual) as total_harga from penjualan_qty_temp where status = $_GET[status] and akun_id = $_SESSION[id]";

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

//membuat array
$row = mysqli_fetch_assoc($result);

echo json_encode($row, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
