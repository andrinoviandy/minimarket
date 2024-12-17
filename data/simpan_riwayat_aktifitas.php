<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$insert = mysqli_query($koneksi, "insert into riwayat_aktifitas (riwayat_admin_id,aktifitas,page,nama_tabel,id_tabel,keterangan) values(" . $_SESSION['id_riwayat'] . ", '" . $_POST['aktifitas'] . "', '" . $_POST['page'] . "', '" . $_POST['nama_tabel'] . "', " . $_POST['id_tabel'] . ", '" . $_POST['keterangan'] . "') ");
if ($insert) {
    echo "S";
} else {
    echo "F";
}
