<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$s1 = mysqli_query($koneksi, "insert into pinjaman values(UUID(),'" . $_POST['nasabah_id'] . "','" . $_POST['tgl_pinjam'] . "','" . str_replace(".", "", $_POST['nominal_pinjam']) . "','" . $_POST['keterangan'] . "', '" . $_POST['buku_kas_id'] . "', '0', '" . $_SESSION['nama'] . "')");
if ($s1) {
    echo "S";
} else {
    echo "F";
}
