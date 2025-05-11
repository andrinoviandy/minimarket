<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$cek = mysqli_fetch_array(mysqli_query($koneksi, "select saldo from buku_kas where id = '$_POST[buku_kas_id]'"));

if ($cek['saldo'] >= str_replace(".", "", $_POST['nominal_pinjam'])) {
    $s1 = mysqli_query($koneksi, "insert into pinjaman values(UUID(),'" . $_POST['nasabah_id'] . "','" . $_POST['tgl_pinjam'] . "','" . str_replace(".", "", $_POST['nominal_pinjam']) . "','" . $_POST['keterangan'] . "', '" . $_POST['buku_kas_id'] . "', '0', '" . $_SESSION['nama'] . "')");

    $up = mysqli_query($koneksi, "update buku_kas set saldo=saldo-'" . str_replace(".", "", $_POST['nominal_pinjam']) . "' where id='$_POST[buku_kas_id]'");

    if ($s1 && $up) {
        die("S");
    } else {
        die("F");
    }
} else {
    die('TC&' . number_format($cek['saldo'], 0, ',', '.'));
}
