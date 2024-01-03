<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");
mysqli_set_charset($koneksi, 'utf8');

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);

//menampilkan data dari database, table tb_anggota
if (isset($_GET['start'])) {

    // yang dipakai
    if (isset($_GET['cari'])) {
        $sql = "select *,pembeli.id as idd from pembeli,tb_laporan_kerusakan_cs,alamat_provinsi,alamat_kecamatan,alamat_kabupaten where pembeli.id=tb_laporan_kerusakan_cs.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and (nama_pembeli like '%$_GET[cari]%' or jalan like '%$_GET[cari]%' or kontak_rs like '%$_GET[cari]%' or nama_penelepon like '%$_GET[cari]%' or keluhan like '%$_GET[cari]%') group by pembeli.id order by nama_pembeli ASC LIMIT $start, $limit";
    } else {
        $sql = "select *,pembeli.id as idd from pembeli,tb_laporan_kerusakan_cs,alamat_provinsi,alamat_kecamatan,alamat_kabupaten where pembeli.id=tb_laporan_kerusakan_cs.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id group by pembeli.id order by nama_pembeli ASC LIMIT $start, $limit";
    }

    $result = mysqli_query($koneksi, $sql) or die("Error " . mysqli_error($koneksi));

    //membuat array
    while ($row = mysqli_fetch_assoc($result)) {
        $ArrAnggota[] = $row;
    }

    echo json_encode($ArrAnggota, JSON_PRETTY_PRINT);

    //tutup koneksi ke database
    mysqli_close($koneksi);
} else {
    //untuk jumlah

    if (isset($_GET['cari'])) {
        $sql = "select COUNT(DISTINCT pembeli.id) as jml from pembeli,tb_laporan_kerusakan_cs,alamat_provinsi,alamat_kecamatan,alamat_kabupaten where pembeli.id=tb_laporan_kerusakan_cs.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id and (nama_pembeli like '%$_GET[cari]%' or jalan like '%$_GET[cari]%' or kontak_rs like '%$_GET[cari]%' or nama_penelepon like '%$_GET[cari]%' or keluhan like '%$_GET[cari]%')";
    } else {
        $sql = "select COUNT(DISTINCT pembeli.id) as jml from pembeli,tb_laporan_kerusakan_cs,alamat_provinsi,alamat_kecamatan,alamat_kabupaten where pembeli.id=tb_laporan_kerusakan_cs.pembeli_id and alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id";
    }

    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
//batasssssssssssssss
