<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$data = mysqli_fetch_array(mysqli_query($koneksi, "select b.ketentuan from tabungan a inner join jenis_tabungan b on b.id = a.jenis_tabungan_id where a.id = '$_GET[id]'"));
echo $data['ketentuan'];
