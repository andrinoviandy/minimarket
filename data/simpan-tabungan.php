<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$s1 = mysqli_query($koneksi, "insert into tabungan values(UUID(),'" . $_POST['nasabah_id'] . "','" . $_POST['tgl_buka_tabungan'] . "','" . $_POST['jenis_tabungan_id'] . "','" . $_POST['keterangan'] . "',1, '" . $_SESSION['nama'] . "')");
if ($s1) {
    echo "S";
} else {
    echo "F";
}