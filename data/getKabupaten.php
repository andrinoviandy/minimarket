<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$q1 = mysqli_query($koneksi, "select * from alamat_kabupaten where id = $_GET[id]");
$row1 = mysqli_fetch_array($q1);
echo "Kabupaten ".$row1['nama_kabupaten'];