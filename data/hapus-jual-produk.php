<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);

$simpan1 = mysqli_query($koneksi, "delete from penjualan_qty_temp where id = $_POST[id]");
if ($simpan1) {
    die("S");
} else {
    die('F');
}
