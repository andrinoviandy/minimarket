<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$q = mysqli_query($koneksi, "update barang_dikirim set alamat2='" . str_replace("\n", '<br>', $_POST['alamat']) . "' where id=" . $_POST['id'] . "");
if ($q) {
    echo "S";
} else {
    echo "F";
}
