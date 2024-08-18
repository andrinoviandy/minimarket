<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "select * from barang_gudang where id = " . $_GET['id'] . ""));
echo json_encode($data);