<?php
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");
error_reporting(0);

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;

if (isset($_GET['start'])) {
    $start = mysqli_real_escape_string($koneksi, $_GET['start']);
    if (isset($_GET['cari'])) {
        $sql = "select *,aksesoris.id as idd from aksesoris where nama_akse like '%$_GET[cari]%' or merk_akse like '%$_GET[cari]%' or tipe_akse like '%$_GET[cari]%' or negara_asal_akse like '%$_GET[cari]%' or deskripsi_akse like '%$_GET[cari]%' group by aksesoris.id order by aksesoris.id desc LIMIT $start, $limit";
    } else {
        $sql = "select *,aksesoris.id as idd from aksesoris group by aksesoris.id order by id desc LIMIT $start, $limit";
    }
} else {
    //untuk jumlah
    if (isset($_GET['cari'])) {
        $sql = "select * from aksesoris where nama_akse like '%$_GET[cari]%' or merk_akse like '%$_GET[cari]%' or tipe_akse like '%$_GET[cari]%' or negara_asal_akse like '%$_GET[cari]%' or deskripsi_akse like '%$_GET[cari]%' group by aksesoris.id";
    } else {
        $sql = "select * from aksesoris order by id desc";
    }
}

$result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

//membuat array
while ($row = mysqli_fetch_assoc($result)) {
    $ArrAnggota[] = $row;
}

echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

//tutup koneksi ke database
mysqli_close($koneksi);
