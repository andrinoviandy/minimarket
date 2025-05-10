<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$Result = mysqli_query($koneksi, "update buku_kas set no_akun='" . $_POST['no_akun'] . "',nama_akun='" . $_POST['nama_akun'] . "', tipe_akun='" . $_POST['akun_tipe'] . "' where id='" . $_POST['id'] . "'");
if ($Result) {
    echo "S";
} else {
    echo "F";
}
