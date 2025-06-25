<?php
include("../config/koneksi.php");
include("../include/API.php");
include("../include/helper.php");
session_start();
mysqli_begin_transaction($koneksi);
$pelanggan = $koneksi->prepare("insert into piutang(penjualan_id, no_pembayaran, tgl_pembayaran, nominal_pembayaran, deskripsi) values(?, ?, ?, ?, ?)");
$params = [$_POST['id'], $_POST['nomor'], $_POST['tgl'], str_replace(".", "", $_POST['nominal']), $_POST['deskripsi']];
$types = getBindTypes($params);
$pelanggan->bind_param($types, ...$params);
$simpan1 = $pelanggan->execute();
if ($simpan1) {
    mysqli_commit($koneksi);
    die('S');
} else {
    mysqli_rollback($koneksi);
    die('F');
}
