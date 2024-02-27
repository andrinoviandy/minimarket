<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$id = $_POST['id_lamp2'];
$max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id)+1 as maks from alat_pelatihan"));
//$ext = explode(".",$_FILES['lamp1']['name']);
$ext2 = explode(".", $_FILES['lamp2']['name']);
//$lamp1="Lampiran1_".$max['maks'].".".$ext[1];
if ($_FILES['lamp2']['name'] != '') {
    $lamp2 = "Lampiran2_" . $max['maks'] . "." . $ext2[1];
} else {
    $lamp2 = "";
}
$R = mysqli_query($koneksi, "update alat_pelatihan set lamp2='$lamp2' where id=$id");
if ($R) {
    copy($_FILES['lamp2']['tmp_name'], "../gambar_pelatihan/lampiran2/$lamp2");
    echo "S";
} else {
    echo "F";
}
