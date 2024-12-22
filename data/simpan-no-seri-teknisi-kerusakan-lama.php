<?php
include("../config/koneksi.php");
session_start();
// error_reporting(0);
$da = mysqli_fetch_array(mysqli_query($koneksi, "select *,pembeli.id as idd from pembeli,alamat_provinsi,alamat_kecamatan,alamat_kabupaten,tb_laporan_kerusakan_cs where alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and pembeli.id=$_POST[id] and pembeli.id=tb_laporan_kerusakan_cs.pembeli_id"));

if ($da['tgl_lapor'] > $_POST['tgl_garansi_habis']) {
    $gr = "Habis";
} else {
    $gr = "Masih";
}
$sel = mysqli_fetch_array(mysqli_query($koneksi, "select count(*) as jml from tb_laporan_kerusakan_detail where alat_pelatihan_id = ".$_POST['id_akse'].""));
if ($sel['jml'] > 0) {
    die('SA');
} else {
    $Result = mysqli_query($koneksi, "insert tb_laporan_kerusakan_detail values('','" . $_POST['id_lapor'] . "','" . $_POST['id_akse'] . "','$gr','" . $_POST['id_kategori'] . "','" . str_replace("\n", "<br>", $_POST['problem']) . "','" . $_POST['teknisi'] . "')");
    $max = mysqli_fetch_array(mysqli_query($koneksi, "select max(id) as id_max from tb_laporan_kerusakan_detail"));
    $Result2 = mysqli_query($koneksi, "insert tb_maintenance_detail values('','" . $max['id_max'] . "','0','0')");
    if ($Result and $Result2) {
        echo "S";
    } else {
        echo "F";
    }
}
