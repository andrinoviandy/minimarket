<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$simpan = mysqli_query($koneksi, "update barang_gudang_detail set qrcode='" . str_replace("%20", " ", $_POST['qrcode']) . "' where id=" . $_POST['id_ubah'] . "");
if ($simpan) {
    echo "S";
} else {
    echo "F";
}
