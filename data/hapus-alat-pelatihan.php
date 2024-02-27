<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
error_reporting(0);
$q = mysqli_fetch_array(mysqli_query($koneksi, "select * from alat_pelatihan where id=" . $_POST['id_hapus'] . ""));
unlink("../gambar_pelatihan/lampiran1/$q[lamp1]");
unlink("../gambar_pelatihan/lampiran2/$q[lamp2]");
$hapus1 = mysqli_query($koneksi, "delete from peserta_pelatihan where alat_pelatihan_id=" . $_POST['id_hapus'] . "");
if ($hapus1) {
    mysqli_query($koneksi, "update alat_uji_detail set status_pelatihan=0 where id=" . $q['alat_uji_detail_id'] . "");
    $hapus = mysqli_query($koneksi, "delete from alat_pelatihan where id=" . $_POST['id_hapus'] . "");
    if ($hapus) {
        echo "S";
    } else {
        echo "F";
    }
}
