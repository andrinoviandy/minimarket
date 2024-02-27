<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$cek = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from alat_pelatihan where alat_uji_detail_id=$_POST[id_hapus]"));
if ($cek['jml'] > 0) {
    die('TB');
} else {
    $d = mysqli_fetch_array(mysqli_query($koneksi, "select * from alat_uji_detail where id=$_POST[id_hapus]"));
    unlink("../gambar_fi/instalasi/$d[lampiran_i]");
    unlink("../gambar_fi/fungsi/$d[lampiran_f]");
    $hapus = mysqli_query($koneksi, "delete from alat_uji_detail where id=" . $_POST['id_hapus'] . "");
    if ($hapus) {
        mysqli_query($koneksi, "update barang_teknisi_detail set status_uji=0 where id=$d[barang_teknisi_detail_id]");
        echo "S";
    } else {
        echo "F";
    }
}
