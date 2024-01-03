<?php
include("../config/koneksi.php");
session_start();
error_reporting(0);
$up = mysqli_query($koneksi, "update barang_gudang set harga_satuan='" . str_replace(".", "", $_POST['nominal']) . "' where id=" . $_POST['id_brg'] . "");
if ($up) {
    echo "S";
} else {
    echo "F";
}
