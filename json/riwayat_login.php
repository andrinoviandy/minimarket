<?php
error_reporting(0);
header("Content-type:application/json");

//koneksi ke database
require("../config/koneksi.php");

$query = mysqli_query($koneksi, "SELECT jumlah_limit FROM limiter");
list($surat_masuk) = mysqli_fetch_array($query);
//pagging
$limit = $surat_masuk;
$start = mysqli_real_escape_string($koneksi, $_GET['start']);


if (isset($_GET['start'])) {
    if (isset($_GET['cari'])) {
        $sql = "select *,riwayat_admin.id as idd from riwayat_admin where (username like '%$_GET[cari]%') order by id desc LIMIT $start, $limit";
    } else {
        $sql = "select *,riwayat_admin.id as idd from riwayat_admin order by id desc LIMIT $start, $limit";
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
        $sql = "select COUNT(DISTINCT id) as jml from riwayat_admin where (username like '%$_GET[cari]%')";
    } else {
        $sql = "select COUNT(DISTINCT id) as jml from riwayat_admin";
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
//menampilkan data dari database, table tb_anggota
// $sql = "select *,pembeli.id as idd from pembeli,alamat_provinsi,alamat_kabupaten,alamat_kecamatan where alamat_provinsi.id=pembeli.provinsi_id and alamat_kabupaten.id=pembeli.kabupaten_id and alamat_kecamatan.id=pembeli.kecamatan_id group by nama_pembeli order by nama_pembeli ASC";
