<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
if ($_POST['no_seri'] == '') {
    echo "K";
} else {
    $simpan = mysqli_query($koneksi, "insert into barang_demo_kembali_hash values('','" . $_SESSION['id'] . "','" . $_POST['tgl_kembali'] . "','" . $_POST['no_seri'] . "','" . $_POST['kondisi'] . "','" . $_POST['keterangan'] . "')");
    if ($simpan) {
        echo "S";
    } else {
        echo "F";
    }
}
