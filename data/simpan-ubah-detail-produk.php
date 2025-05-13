<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);

$u = mysqli_query($koneksi, "update produk_detail set qrcode='" . $_POST['qrcode'] . "', tgl_expired='" . $_POST['tgl_expired'] . "' where id=" . $_POST['id_ubah'] . "");
if ($u) {
    echo "S";
} else {
    echo "F";
}
