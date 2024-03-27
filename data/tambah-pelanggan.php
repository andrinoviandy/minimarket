<?php
include("../config/koneksi.php");
// include("../include/API.php");
session_start();
error_reporting(0);
$insert_pembeli = mysqli_query($koneksi, "insert into pembeli values('','" . $_POST['nama_pembeli'] . "','" . $_POST['provinsi'] . "','" . $_POST['kabupaten'] . "','" . $_POST['kecamatan'] . "','" . $_POST['kelurahan'] . "','" . $_POST['alamat'] . "','" . $_POST['kontak_rs'] . "')");
if ($insert_pembeli) {
    echo "S";
} else {
    echo "F";
}
