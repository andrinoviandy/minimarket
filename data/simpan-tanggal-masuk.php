<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$q_lunas = mysqli_query($koneksi, "update barang_pesan set tgl_masuk_gudang='" . $_POST['tgl'] . "' where id=$_POST[id]");
if ($q_lunas) {
    echo "S";
} else {
    echo "F";
}
