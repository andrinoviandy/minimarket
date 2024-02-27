<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$qq = mysqli_fetch_array(mysqli_query($koneksi, "select * from alat_uji_detail where id=" . $_POST['id_f'] . ""));
unlink("../gambar_fi/fungsi/$qq[lampiran_f]");
$max2 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id)+1 as maks from alat_uji_detail"));
$ext2 = explode(".", $_FILES['lampiran_f']['name']);
if ($_FILES['lampiran_f']['name'] != '') {
    $lamp_f = "Fungsi" . $_POST['id_f'] . "." . $ext2[1];
} else {
    $lamp_f = "";
}
$u2 = mysqli_query($koneksi, "update alat_uji_detail set lampiran_f='" . $lamp_f . "' where id=" . $_POST['id_f'] . "");
if ($u2) {
    copy($_FILES['lampiran_f']['tmp_name'], "../gambar_fi/fungsi/" . $lamp_f);
    echo "S";
} else {
    echo "F";
}
