<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$u = mysqli_query($koneksi, "update alat_uji_detail set soft_version='" . $_POST['soft_version'] . "',tgl_garansi_habis='" . $_POST['tgl_garansi'] . "',tgl_i='" . $_POST['tgl_i'] . "', tgl_f='" . $_POST['tgl_f'] . "', keterangan='" . $_POST['keterangan'] . "' where id=" . $_POST['id_ubah'] . "");
if ($u) {
    echo "S";
} else {
    echo "F";
}
