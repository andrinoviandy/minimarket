<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$Result = mysqli_query($koneksi, "update pembeli set nama_pembeli='" . $_POST['nama_pembeli'] . "', provinsi_id='" . $_POST['provinsi'] . "',kabupaten_id='" . $_POST['kabupaten'] . "', kecamatan_id='" . $_POST['kecamatan'] . "', kelurahan_id='" . $_POST['kelurahan_id'] . "', jalan='" . $_POST['jalan'] . "', kontak_rs='" . $_POST['kontak'] . "' where nama_pembeli='" . $_POST['nama_awal'] . "'");
if ($Result) {
    echo "S";
} else {
    echo "F";
}
