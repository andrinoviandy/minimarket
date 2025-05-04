<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$sel = mysqli_fetch_array(mysqli_query($koneksi, "select * from deposit where id=" . $_POST['id'] . ""));
$up1 = mysqli_query($koneksi, "update buku_kas set saldo=saldo+$sel[nominal_deposit] where id=" . $sel['dari_akun_id'] . "");
$up2 = mysqli_query($koneksi, "update buku_kas set saldo=saldo-$sel[nominal_deposit] where id=" . $sel['ke_akun_id'] . "");
if ($up1 && $up2) {
    $del2 = mysqli_query($koneksi, "delete from deposit where id=" . $_POST['id'] . "");
    if ($del2) {
        echo "S";
    } else {
        echo "F";
    }
}
