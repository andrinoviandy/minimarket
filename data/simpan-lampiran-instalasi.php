<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$qq = mysqli_fetch_array(mysqli_query($koneksi, "select * from alat_uji_detail where id=" . $_POST['id_i'] . ""));
unlink("../gambar_fi/instalasi/$qq[lampiran_i]");
$max2 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id)+1 as maks from alat_uji_detail"));
$ext2 = explode(".", $_FILES['lampiran_i']['name']);
if ($_FILES['lampiran_i']['name'] != '') {
    $lamp_f = $_POST['id_i'] . "." . $ext2[1];
} else {
    $lamp_f = "";
}
$u2 = mysqli_query($koneksi, "update alat_uji_detail set lampiran_i='" . $lamp_f . "' where id=" . $_POST['id_i'] . "");
if ($u2) {
    copy($_FILES['lampiran_i']['tmp_name'], "../gambar_fi/instalasi/" . $lamp_f);
    echo "S";
} else {
    echo "F";
}
