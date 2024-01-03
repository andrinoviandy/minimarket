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
        $sql = "select *,barang_inventory.id as idd from barang_inventory where nama_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or negara_asal like '%$_GET[cari]%' or deskripsi_alat like '%$_GET[cari]%' group by barang_inventory.id order by barang_inventory.id desc LIMIT $start, $limit";
    } else {
        $sql = "select *,barang_inventory.id as idd from barang_inventory group by barang_inventory.id order by id desc LIMIT $start, $limit";
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
        $sql = "select COUNT(*) as jml from barang_inventory where nama_brg like '%$_GET[cari]%' or merk_brg like '%$_GET[cari]%' or tipe_brg like '%$_GET[cari]%' or negara_asal like '%$_GET[cari]%' or deskripsi_alat like '%$_GET[cari]%'";
    } else {
        $sql = "select COUNT(*) as jml from barang_inventory";
    }
    $result = mysqli_fetch_array(mysqli_query($koneksi, $sql));
    echo $result['jml'];
    //tutup koneksi ke database
    mysqli_close($koneksi);
}
