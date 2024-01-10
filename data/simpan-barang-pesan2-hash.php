<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$simpan = mysqli_query($koneksi, "insert into barang_pesan_hash values('','" . $_SESSION['id'] . "','" . $_POST['id_akse'] . "','" . $_POST['qty'] . "','" . $_SESSION['mata_uang'] . "','" . $_POST['harga_perunit'] . "','" . $_POST['diskon'] . "','" . $_POST['total_harga'] . "','" . $_POST['catatan_spek'] . "')");
if ($simpan) {
    echo "S";
} else {
    echo "F";
}
