<?php
include("../config/koneksi.php");
include("../include/API.php");
session_start();
// error_reporting(0);
$max2 = mysqli_fetch_array(mysqli_query($koneksi, "select max(id)+1 as maks from barang_gudang_detail_rusak_progress"));
$ext2 = explode(".", $_FILES['lampiran']['name']);
$lamp_f = "BarangRusak$max2[maks]" . "." . $ext2[1];
$queri_simpan = mysqli_query($koneksi, "insert into barang_gudang_detail_rusak_progress values('','" . $_POST['id_ubah'] . "','" . $_POST['tgl'] . "','" . $_POST['deskripsi_kerusakan'] . "','" . $_POST['deskripsi_perbaikan'] . "','$lamp_f')");

if ($queri_simpan) {
    copy($_FILES['lampiran']['tmp_name'], "../gambar_progress_belum_dijual/$lamp_f");
    //mysqli_query($koneksi, "update tb_maintenance_detail set status_proses=1 where id=".$_GET['id_alkes']."");
    echo "S";
} else {
    echo "F";
}
