<?php
include("../config/koneksi.php");
include("../config/koneksi_kantin.php");
include("../include/API.php");
session_start();
// error_reporting(0);

$simpan1 = mysqli_query($koneksi, "update penjualan_qty_temp set penjualan_id = '', status = 0 where akun_id = $_SESSION[id] and penjualan_id = $_POST[id_jual]");

if ($simpan1) {
    mysqli_query($koneksi, "delete from penjualan where id = " . $_POST['id_jual'] . "");
    die('S');
} else {
    die('F');
}
