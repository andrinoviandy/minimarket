<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);

$upd = mysqli_query($koneksi, "update produk_po set dihapus=dihapus+1 where id=" . $_POST['id_po'] . "");
$del = mysqli_query($koneksi, "delete from produk_detail where id=" . $_POST['id_hapus'] . "");

if ($upd && $del) {
    echo "S";
} else {
    echo "F";
}
